CREATE TABLE IF NOT EXISTS profile (
 id BIGSERIAL PRIMARY KEY,
 name VARCHAR(160) NOT NULL,
 headline VARCHAR(255),
 intro TEXT,
 bio TEXT,
 email VARCHAR(255),
 location VARCHAR(160),
 cv_url TEXT,
 updated_at TIMESTAMPTZ NOT NULL DEFAULT NOW()
);

CREATE TABLE IF NOT EXISTS projects (
 id BIGSERIAL PRIMARY KEY,
 name VARCHAR(180) NOT NULL,
 slug VARCHAR(180) UNIQUE NOT NULL,
 category VARCHAR(100) NOT NULL,
 summary TEXT NOT NULL,
 url TEXT,
 featured BOOLEAN NOT NULL DEFAULT FALSE,
 published BOOLEAN NOT NULL DEFAULT TRUE,
 sort_order INT NOT NULL DEFAULT 0,
 created_at TIMESTAMPTZ NOT NULL DEFAULT NOW()
);

CREATE TABLE IF NOT EXISTS services (
 id BIGSERIAL PRIMARY KEY,
 name VARCHAR(180) NOT NULL,
 summary TEXT NOT NULL,
 published BOOLEAN NOT NULL DEFAULT TRUE,
 sort_order INT NOT NULL DEFAULT 0
);

CREATE TABLE IF NOT EXISTS skills (
 id BIGSERIAL PRIMARY KEY,
 name VARCHAR(120) NOT NULL,
 sort_order INT NOT NULL DEFAULT 0
);

CREATE TABLE IF NOT EXISTS messages (
 id BIGSERIAL PRIMARY KEY,
 name VARCHAR(160) NOT NULL,
 email VARCHAR(255) NOT NULL,
 subject VARCHAR(255),
 message TEXT NOT NULL,
 status VARCHAR(30) NOT NULL DEFAULT 'new',
 created_at TIMESTAMPTZ NOT NULL DEFAULT NOW()
);

CREATE TABLE IF NOT EXISTS admins (
 id BIGSERIAL PRIMARY KEY,
 email VARCHAR(255) UNIQUE NOT NULL,
 password_hash TEXT NOT NULL,
 created_at TIMESTAMPTZ NOT NULL DEFAULT NOW()
);

INSERT INTO profile(name,headline,intro,bio,email,location)
SELECT 'Yurian','Software Engineer · AI Builder · Technology Creator',
'Technology-focused builder creating reliable software, intelligent systems and digital products.',
'I build software products, business systems and AI-powered experiences with a focus on usefulness, reliability and long-term maintainability.',
NULL,'Tanzania'
WHERE NOT EXISTS (SELECT 1 FROM profile);

INSERT INTO projects(name,slug,category,summary,featured,sort_order)
VALUES
('YURIAN AI OS','yurian-ai-os','AI / Software','An AI-native operating environment for knowledge, projects, documents, workflows and intelligent agents.',TRUE,1),
('Altavox Technologies','altavox-technologies','Technology','A technology brand and product ecosystem focused on digital business and software systems.',TRUE,2),
('Sammena School System','sammena-school-system','Education / SaaS','Digital school management and academic operations platform for modern school administration.',TRUE,3)
ON CONFLICT (slug) DO NOTHING;

INSERT INTO services(name,summary,sort_order)
VALUES
('Software Engineering','Custom web applications, APIs and business systems.',1),
('AI Systems','AI agents, automation and intelligent workflows.',2),
('Web Development','Fast, responsive and production-ready websites.',3),
('Business Automation','Digital workflows that reduce repetitive operational work.',4)
ON CONFLICT DO NOTHING;

INSERT INTO skills(name,sort_order)
VALUES
('PHP'),('PostgreSQL'),('JavaScript'),('HTML5'),('CSS3'),('Docker'),('GitHub'),('AI Engineering'),('REST APIs'),('System Architecture')
ON CONFLICT DO NOTHING;
