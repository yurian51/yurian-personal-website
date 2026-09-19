INSERT INTO experience(role,organization,location,start_date,current_role,summary,sort_order)
VALUES
('Independent Software Engineer / Product Builder','Yurian','Tanzania',DATE '2024-01-01',TRUE,'Designing and building production software across business systems, education platforms, connectivity infrastructure, AI workflows and digital products.',1),
('Founder / Technology Builder','YURIAN TECH LTD','Tanzania',DATE '2024-01-01',TRUE,'Building software products and technology services with an emphasis on full-stack engineering, system architecture and practical delivery.',2),
('Founder / Product Builder','Altavox Technologies','Tanzania',DATE '2025-01-01',TRUE,'Developing technology products and digital business systems across automation, software platforms and intelligent workflows.',3)
ON CONFLICT DO NOTHING;