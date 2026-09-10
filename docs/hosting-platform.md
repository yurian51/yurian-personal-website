# Multi-tenant hosting platform direction

## Important boundary

This repository is now a production-deployable website with a bookstore. It is **not yet a hosting platform for arbitrary third-party websites**. A Render/Railway-style product needs a separate control plane, isolated build and runtime workers, domain routing, secret management, usage metering, and abuse controls. Adding a privileged Docker runner directly into this public website would create a serious remote-code-execution and tenant-isolation risk.

The correct architecture is to keep this website as the marketing and account surface, then build a separate hosting control plane and worker service. The website can later link to that platform or share authentication, but it should not execute customer containers.

## Proposed product architecture

| Service | Responsibility | Isolation boundary |
|---|---|---|
| Control plane | Users, projects, GitHub repositories, environment variables, deploy history, domains, billing state | PostgreSQL row-level authorization and server-side secrets |
| Build worker | Clone a selected commit, run a user-defined build, produce an OCI image or static artifact | Ephemeral sandbox/VM per build, CPU/time/memory/network limits |
| Image/artifact registry | Store immutable container images and static bundles | Private registry credentials, retention policy, malware scanning |
| Runtime scheduler | Start, stop, restart, scale, and health-check deployments | Separate namespace/VM per tenant, least-privilege runtime identity |
| Edge router | TLS, custom domains, wildcard subdomains, HTTP routing | Managed load balancer and certificate automation |
| Object storage | Build logs, deployment artifacts, user uploads, backups | Per-tenant prefixes/buckets and signed URLs |
| Metering and operations | CPU, memory, bandwidth, storage, logs, alerts, quotas | Immutable usage events and admin audit trail |

## Suggested first version

The safest first release should support static sites and Docker projects from GitHub. A user creates a project, selects a repository and branch, supplies non-secret build settings, and clicks deploy. The control plane creates a build job; a disposable worker builds the artifact; the runtime service deploys only an immutable image or static bundle. Every deployment receives a generated subdomain such as `project-id.platform.example.com`.

Custom domains, payment plans, autoscaling, preview deployments, and arbitrary background workers should come after the build/deploy/rollback path is observable and isolated. Do not allow privileged containers, host networking, unrestricted outbound traffic, Docker socket mounts, or user-controlled reverse-proxy configuration in the first version.

## Platform choices

For a practical launch, use an existing container provider for the workers and managed PostgreSQL/object storage rather than running a cluster inside this PHP web app. Render, Railway, Fly.io, or a managed Kubernetes service can host the worker workloads while this application supplies the account and deployment UX. A true self-hosted platform requires a persistent control-plane host, a queue, a registry, isolated workers, DNS provider access, and a monitoring stack.

The current repository is prepared for this path through Docker packaging, health checks, deployment documentation, and S3-compatible storage abstractions. The next implementation should be a separate `yurian-hosting-control-plane` project, not a privileged feature inside `yurian-personal-website`.

## Minimum security requirements

Every build must run as an unprivileged user with a hard timeout and resource limits. Secrets must be injected at runtime and never written into build logs or images. Deployment callbacks and worker messages must be authenticated and idempotent. Logs must redact environment values. Tenant data must be separated in PostgreSQL, object storage, registry namespaces, and runtime scheduling. Admin actions require audit logs and an emergency kill switch.
