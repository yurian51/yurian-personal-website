INSERT INTO project_details(project_id,problem,approach,architecture,status,outcomes,repository_url,live_url)
SELECT p.id,
'Build a vendor-neutral connectivity platform that can connect money, service entitlement, identity, network access, session accounting and enforcement into one traceable lifecycle.',
'Converge billing, entitlement, identity, RADIUS/AAA, network control, sessions and reconciliation around a shared correlation identity while keeping provider integrations behind adapters.',
'Hybrid connectivity fabric with web application services, PostgreSQL, Redis-oriented workflows, RADIUS/AAA integration, provider adapters and network command boundaries.',
'Active development',
'Production-oriented platform work focused on verified payment-to-access execution, provider-neutral network control and auditable lifecycle reconciliation.',
'https://github.com/yurian51/Jaslyn-Net',
NULL
FROM projects p
WHERE p.slug='jaslyn-net'
ON CONFLICT (project_id) DO UPDATE SET problem=EXCLUDED.problem,approach=EXCLUDED.approach,architecture=EXCLUDED.architecture,status=EXCLUDED.status,outcomes=EXCLUDED.outcomes,repository_url=EXCLUDED.repository_url,live_url=EXCLUDED.live_url,updated_at=NOW();

INSERT INTO project_technologies(project_id,technology,sort_order)
SELECT p.id,x.technology,x.sort_order FROM projects p
CROSS JOIN (VALUES ('Next.js',1),('TypeScript',2),('NestJS',3),('PostgreSQL',4),('Redis',5),('RADIUS',6),('MikroTik',7),('Docker',8)) x(technology,sort_order)
WHERE p.slug='jaslyn-net'
ON CONFLICT DO NOTHING;