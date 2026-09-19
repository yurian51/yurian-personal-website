CREATE TABLE IF NOT EXISTS project_details (
 id BIGSERIAL PRIMARY KEY,
 project_id BIGINT NOT NULL UNIQUE REFERENCES projects(id) ON DELETE CASCADE,
 problem TEXT NOT NULL,
 approach TEXT NOT NULL,
 architecture TEXT NOT NULL,
 status VARCHAR(60) NOT NULL DEFAULT 'Active',
 outcomes TEXT,
 repository_url TEXT,
 live_url TEXT,
 updated_at TIMESTAMPTZ NOT NULL DEFAULT NOW()
);

CREATE TABLE IF NOT EXISTS project_technologies (
 id BIGSERIAL PRIMARY KEY,
 project_id BIGINT NOT NULL REFERENCES projects(id) ON DELETE CASCADE,
 technology VARCHAR(120) NOT NULL,
 sort_order INT NOT NULL DEFAULT 0,
 UNIQUE(project_id, technology)
);

CREATE TABLE IF NOT EXISTS engineering_domains (
 id BIGSERIAL PRIMARY KEY,
 name VARCHAR(160) NOT NULL UNIQUE,
 summary TEXT NOT NULL,
 technologies TEXT NOT NULL,
 sort_order INT NOT NULL DEFAULT 0,
 published BOOLEAN NOT NULL DEFAULT TRUE
);

CREATE TABLE IF NOT EXISTS experience (
 id BIGSERIAL PRIMARY KEY,
 role VARCHAR(180) NOT NULL,
 organization VARCHAR(180) NOT NULL,
 location VARCHAR(160),
 start_date DATE,
 end_date DATE,
 current_role BOOLEAN NOT NULL DEFAULT FALSE,
 summary TEXT NOT NULL,
 sort_order INT NOT NULL DEFAULT 0,
 published BOOLEAN NOT NULL DEFAULT TRUE
);

CREATE TABLE IF NOT EXISTS achievements (
 id BIGSERIAL PRIMARY KEY,
 label VARCHAR(160) NOT NULL,
 value VARCHAR(120) NOT NULL,
 description TEXT,
 source_url TEXT,
 sort_order INT NOT NULL DEFAULT 0,
 published BOOLEAN NOT NULL DEFAULT TRUE
);

CREATE TABLE IF NOT EXISTS build_threads (
 id BIGSERIAL PRIMARY KEY,
 name VARCHAR(180) NOT NULL,
 category VARCHAR(100) NOT NULL,
 status VARCHAR(40) NOT NULL DEFAULT 'active',
 summary TEXT NOT NULL,
 progress SMALLINT CHECK (progress >= 0 AND progress <= 100),
 project_slug VARCHAR(180),
 updated_at TIMESTAMPTZ NOT NULL DEFAULT NOW(),
 published BOOLEAN NOT NULL DEFAULT TRUE,
 sort_order INT NOT NULL DEFAULT 0
);

CREATE INDEX IF NOT EXISTS idx_project_details_project ON project_details(project_id);
CREATE INDEX IF NOT EXISTS idx_project_technologies_project ON project_technologies(project_id,sort_order);
CREATE INDEX IF NOT EXISTS idx_engineering_domains_published ON engineering_domains(published,sort_order);
CREATE INDEX IF NOT EXISTS idx_experience_published ON experience(published,sort_order);
CREATE INDEX IF NOT EXISTS idx_achievements_published ON achievements(published,sort_order);
CREATE INDEX IF NOT EXISTS idx_build_threads_published ON build_threads(published,sort_order);

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
ON CONFLICT (project_id) DO NOTHING;

INSERT INTO projects(name,slug,category,summary,featured,sort_order)
VALUES
('Jaslyn Net','jaslyn-net','Network / ISP / FinTech','A universal connectivity operating fabric connecting payments, service entitlement, identity, network access, sessions, accounting, enforcement and reconciliation.',TRUE,0),
('Sammena Primary School','sammena-primary-school','Education / SIS','A school information and operations system covering admissions, students, academics, fees, reports and school workflows.',TRUE,4)
ON CONFLICT (slug) DO NOTHING;

INSERT INTO project_details(project_id,problem,approach,architecture,status,outcomes,repository_url,live_url)
SELECT p.id,
'Turn recurring school administration work into a reliable digital workflow without losing the school-specific rules that make the system useful.',
'Model school operations as explicit domains for identity, students, admissions, assessments, attendance, fees and reporting with role-aware access.',
'Web application architecture with typed APIs, relational persistence, role-based access, school-scoped data boundaries and responsive administrative interfaces.',
'Active development',
'Production-oriented SIS work covering public school information, authenticated school operations, academic data and school-scoped integrity.',
'https://github.com/yurian51/sammena-school-website',
NULL
FROM projects p
WHERE p.slug='sammena-primary-school'
ON CONFLICT (project_id) DO NOTHING;

INSERT INTO project_details(project_id,problem,approach,architecture,status,outcomes,repository_url,live_url)
SELECT p.id,
'Create a technology brand and product ecosystem that can host multiple digital products instead of a collection of unrelated pages.',
'Use a consistent product identity while allowing individual systems to keep their own domain logic, integrations and operational workflows.',
'Modular web product architecture with reusable UI, API integrations, persistent data and room for payment, automation and AI capabilities.',
'Active development',
'Brand and product work spanning digital business systems, automation and technology products.',
NULL,
NULL
FROM projects p
WHERE p.slug='altavox-technologies'
ON CONFLICT (project_id) DO NOTHING;

INSERT INTO project_details(project_id,problem,approach,architecture,status,outcomes,repository_url,live_url)
SELECT p.id,
'Explore how an AI-native environment can keep project context, documents, workflows and intelligent tools connected.',
'Use an AI layer with explicit tool boundaries, structured outputs and persistent project context rather than treating chat as the whole product.',
'Web application with a provider abstraction layer, agent/tool execution boundaries, persistent project data and asynchronous workflows.',
'Active development',
'An ongoing exploration of AI-native software, agents, context management and automation.',
NULL,
NULL
FROM projects p
WHERE p.slug='yurian-ai-os'
ON CONFLICT (project_id) DO NOTHING;

INSERT INTO project_technologies(project_id,technology,sort_order)
SELECT p.id,x.technology,x.sort_order FROM projects p
CROSS JOIN (VALUES ('Next.js',1),('TypeScript',2),('NestJS',3),('PostgreSQL',4),('Redis',5),('RADIUS',6),('MikroTik',7),('Docker',8)) x(technology,sort_order)
WHERE p.slug='jaslyn-net'
ON CONFLICT DO NOTHING;

INSERT INTO project_technologies(project_id,technology,sort_order)
SELECT p.id,x.technology,x.sort_order FROM projects p
CROSS JOIN (VALUES ('Next.js',1),('TypeScript',2),('PostgreSQL',3),('REST APIs',4),('RBAC',5)) x(technology,sort_order)
WHERE p.slug='sammena-primary-school'
ON CONFLICT DO NOTHING;

INSERT INTO project_technologies(project_id,technology,sort_order)
SELECT p.id,x.technology,x.sort_order FROM projects p
CROSS JOIN (VALUES ('TypeScript',1),('Next.js',2),('Node.js',3),('PostgreSQL',4),('AI Agents',5),('Tool Calling',6)) x(technology,sort_order)
WHERE p.slug='yurian-ai-os'
ON CONFLICT DO NOTHING;

INSERT INTO project_technologies(project_id,technology,sort_order)
SELECT p.id,x.technology,x.sort_order FROM projects p
CROSS JOIN (VALUES ('Web Applications',1),('APIs',2),('PostgreSQL',3),('Automation',4)) x(technology,sort_order)
WHERE p.slug='altavox-technologies'
ON CONFLICT DO NOTHING;

INSERT INTO engineering_domains(name,summary,technologies,sort_order)
VALUES
('Software Architecture','Designing systems around explicit domains, boundaries, contracts and failure recovery.','TypeScript · Node.js · NestJS · REST · GraphQL',1),
('Full-Stack Engineering','Building production web applications from interface to persistence and deployment.','Next.js · React · TypeScript · PHP · HTML · CSS',2),
('Data & Backend Systems','Designing reliable APIs, relational models, transactions and background workflows.','PostgreSQL · MySQL · Redis · Prisma · SQL',3),
('Network & ISP Platforms','Connecting subscribers, identity, AAA, billing and network enforcement through provider-neutral boundaries.','MikroTik · RADIUS · PPPoE · Hotspot · IPAM · QoS',4),
('FinTech & Payments','Designing verifiable payment lifecycles with idempotency, reconciliation and auditability.','M-Pesa · Payment APIs · Webhooks · Idempotency',5),
('AI & Automation','Building agentic workflows with explicit tools, structured outputs and persistent context.','AI Agents · Tool Calling · Automation · WebSockets',6),
('Infrastructure & Delivery','Packaging, deploying and operating software with observable production boundaries.','Linux · Docker · NGINX · Render · AWS · CI/CD',7)
ON CONFLICT (name) DO NOTHING;

INSERT INTO achievements(label,value,description,sort_order)
VALUES
('Primary engineering focus','Production systems','Software that must survive real users, real data and real operational constraints.',1),
('Connectivity platform','Jaslyn Net','Universal connectivity operating fabric under active development.',2),
('Education platform','Sammena SIS','School information and operations platform under active development.',3),
('AI systems','Yurian AI OS','AI-native product and agent experimentation under active development.',4)
ON CONFLICT DO NOTHING;

INSERT INTO build_threads(name,category,status,summary,progress,project_slug,sort_order)
VALUES
('Jaslyn Net connectivity lifecycle','Network / FinTech','active','Payment-to-service-to-network lifecycle with shared correlation and verified enforcement.',70,'jaslyn-net',1),
('Yurian Personal Website','Personal Platform','active','Turning the personal website into an engineering portfolio, case-study library and business interface.',60,NULL,2),
('Yurian AI OS','AI / Systems','active','Exploring persistent context, agent tools and AI-native workflows.',45,'yurian-ai-os',3)
ON CONFLICT DO NOTHING;
