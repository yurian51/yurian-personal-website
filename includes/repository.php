<?php
declare(strict_types=1);

function profile(): array
{
    try { return db()->query('SELECT * FROM profile ORDER BY id LIMIT 1')->fetch() ?: []; }
    catch (Throwable $e) { return ['name'=>'Yurian','headline'=>'Software Engineer · AI Builder · Technology Creator','intro'=>'Technology-focused builder creating reliable software, intelligent systems and digital products.','bio'=>'I build software products, business systems and AI-powered experiences with a focus on usefulness, reliability and long-term maintainability.','location'=>'Tanzania']; }
}

function projects(int $limit=12): array
{
    $limit = max(1, min($limit, 100));
    try { $s=db()->prepare('SELECT * FROM projects WHERE published=TRUE ORDER BY featured DESC,sort_order ASC,id DESC LIMIT :limit');$s->bindValue(':limit',$limit,PDO::PARAM_INT);$s->execute();return $s->fetchAll(); }
    catch (Throwable $e) { return [
      ['name'=>'YURIAN AI OS','slug'=>'yurian-ai-os','category'=>'AI / Software','summary'=>'An AI-native operating environment for knowledge, projects, documents, workflows and intelligent agents.','url'=>null,'featured'=>true],
      ['name'=>'Altavox Technologies','slug'=>'altavox-technologies','category'=>'Technology','summary'=>'A technology brand and product ecosystem focused on digital business and software systems.','url'=>null,'featured'=>true],
      ['name'=>'Sammena School System','slug'=>'sammena-school-system','category'=>'Education / SaaS','summary'=>'Digital school management and academic operations platform for modern school administration.','url'=>null,'featured'=>true]
    ]; }
}

function projectBySlug(string $slug): ?array
{
    try { $s=db()->prepare('SELECT * FROM projects WHERE slug=:slug AND published=TRUE LIMIT 1');$s->execute([':slug'=>$slug]);$row=$s->fetch();if($row)return $row; }
    catch (Throwable $e) {}
    foreach(projects(50) as $project){ if(($project['slug'] ?? '') === $slug)return $project; }
    return null;
}

function services(int $limit=12): array
{
    $limit = max(1, min($limit, 100));
    try { $s=db()->prepare('SELECT * FROM services WHERE published=TRUE ORDER BY sort_order ASC,id DESC LIMIT :limit');$s->bindValue(':limit',$limit,PDO::PARAM_INT);$s->execute();return $s->fetchAll(); }
    catch (Throwable $e) { return [
      ['name'=>'Software Engineering','summary'=>'Custom web applications, APIs and business systems.'],
      ['name'=>'AI Systems','summary'=>'AI agents, automation and intelligent workflows.'],
      ['name'=>'Web Development','summary'=>'Fast, responsive and production-ready websites.'],
      ['name'=>'Business Automation','summary'=>'Digital workflows that reduce repetitive operational work.']
    ]; }
}

function skills(): array
{
    try { return db()->query('SELECT * FROM skills ORDER BY sort_order ASC,id ASC')->fetchAll(); }
    catch (Throwable $e) { return array_map(fn($n)=>['name'=>$n],['PHP','PostgreSQL','JavaScript','HTML5','CSS3','Docker','GitHub','AI Engineering','REST APIs','System Architecture']); }
}

function fieldNotes(): array
{
    return [
      ['slug'=>'interface-is-part-of-the-model','type'=>'ESSAY','date'=>'2026-02-09','title'=>'The interface is part of the model','excerpt'=>'A working note on why the layer people touch is not separate from the intelligence underneath.','body'=>['The interface is not a wrapper around the system. It is where the system becomes legible, negotiable, and useful to another person.','When we treat the interface as a final coat of paint, we hide the decisions that matter: what context is visible, what can be changed, and where the human remains in control.','The work is to make those decisions explicit. Good software does not remove complexity by pretending it is gone. It gives complexity a shape we can work with.']],
      ['slug'=>'building-with-a-longer-horizon','type'=>'FIELD NOTE','date'=>'2025-12-11','title'=>'On building with a longer horizon','excerpt'=>'A small argument for software that keeps its promises after the launch post disappears.','body'=>['A product is not finished when it is announced. It is finished when the person using it can trust what happens next.','That trust is built through defaults, recovery paths, clear language, and a willingness to keep the architecture understandable as the surface grows.','The longer horizon is not a slower version of shipping. It is a different definition of done.']],
      ['slug'=>'things-that-changed-how-i-make','type'=>'READING LIST','date'=>'2025-10-03','title'=>'Things that changed how I make','excerpt'=>'A compact library of ideas, tools, and observations that continue to shape the work.','body'=>['I keep returning to things that make the invisible visible: diagrams, notebooks, source code, field recordings, and conversations with people who use what I build.','The common thread is attention. The best tools do not demand more of it than necessary; they help direct it toward the question that matters.','This list will keep changing. That is part of the point.']],
    ];
}

function fieldNoteBySlug(string $slug): ?array
{
    foreach(fieldNotes() as $note){ if(($note['slug'] ?? '') === $slug)return $note; }
    return null;
}

function books(int $limit=24): array
{
    $limit = max(1, min($limit, 100));
    try {
        $query = db()->prepare('SELECT id,title,slug,author,description,price,currency,cover_url,stock_quantity,published FROM books WHERE published=TRUE ORDER BY featured DESC,sort_order ASC,id DESC LIMIT :limit');
        $query->bindValue(':limit', $limit, PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll();
    } catch (Throwable $e) {
        return [
            ['title'=>'The Interface Is Part of the Model','slug'=>'interface-is-part-of-the-model','author'=>'Yurian Mwangi','description'=>'A working book about making intelligent systems legible, negotiable, and useful.','price'=>'18.00','currency'=>'USD','cover_url'=>null,'stock_quantity'=>12,'published'=>true],
            ['title'=>'Building With a Longer Horizon','slug'=>'building-with-a-longer-horizon','author'=>'Yurian Mwangi','description'=>'Notes on defaults, recovery paths, clear language, and software people can trust.','price'=>'15.00','currency'=>'USD','cover_url'=>null,'stock_quantity'=>8,'published'=>true],
            ['title'=>'Things That Changed How I Make','slug'=>'things-that-changed-how-i-make','author'=>'Yurian Mwangi','description'=>'A compact reading and making list for builders who want to keep paying attention.','price'=>'12.00','currency'=>'USD','cover_url'=>null,'stock_quantity'=>20,'published'=>true],
        ];
    }
}

function bookBySlug(string $slug): ?array
{
    try {
        $query = db()->prepare('SELECT id,title,slug,author,description,price,currency,cover_url,stock_quantity,published FROM books WHERE slug=:slug AND published=TRUE LIMIT 1');
        $query->execute([':slug'=>$slug]);
        $book = $query->fetch();
        if ($book) return $book;
    } catch (Throwable $e) {}
    foreach (books(100) as $book) if (($book['slug'] ?? '') === $slug) return $book;
    return null;
}

function cart(): array
{
    $cart = $_SESSION['book_cart'] ?? [];
    if (!is_array($cart)) return [];
    $clean = [];
    foreach ($cart as $slug => $quantity) {
        if (is_string($slug) && preg_match('/^[a-z0-9-]+$/', $slug) && (int)$quantity > 0) {
            $clean[$slug] = min((int)$quantity, 10);
        }
    }
    $_SESSION['book_cart'] = $clean;
    return $clean;
}

function addToCart(string $slug, int $quantity=1): bool
{
    $book = bookBySlug($slug);
    if (!$book || (int)($book['stock_quantity'] ?? 0) < 1) return false;
    $cart = cart();
    $cart[$slug] = min(10, ($cart[$slug] ?? 0) + max(1, $quantity));
    $_SESSION['book_cart'] = $cart;
    return true;
}

function removeFromCart(string $slug): void
{
    $cart = cart();
    unset($cart[$slug]);
    $_SESSION['book_cart'] = $cart;
}

function cartItems(): array
{
    $items = [];
    foreach (cart() as $slug => $quantity) {
        $book = bookBySlug($slug);
        if ($book) {
            $book['quantity'] = min($quantity, max(0, (int)($book['stock_quantity'] ?? $quantity)));
            if ($book['quantity'] > 0) {
                $book['line_total'] = (float)$book['price'] * $book['quantity'];
                $items[] = $book;
            }
        }
    }
    return $items;
}

function cartTotal(): float
{
    return array_reduce(cartItems(), fn(float $total, array $item): float => $total + (float)$item['line_total'], 0.0);
}

function clearCart(): void
{
    unset($_SESSION['book_cart']);
}

function submitBookOrder(string $name, string $email, string $notes, array $items): bool
{
    if ($items === []) return false;
    $pdo = null;
    try {
        $pdo = db();
        $pdo->beginTransaction();
        $order = $pdo->prepare('INSERT INTO book_orders(customer_name,customer_email,notes,total_amount,currency,status) VALUES(:name,:email,:notes,:total,:currency,:status) RETURNING id');
        $order->execute([
            ':name' => $name,
            ':email' => $email,
            ':notes' => $notes !== '' ? $notes : null,
            ':total' => number_format(cartTotal(), 2, '.', ''),
            ':currency' => $items[0]['currency'] ?? 'USD',
            ':status' => 'inquiry',
        ]);
        $orderId = (int)$order->fetchColumn();
        $line = $pdo->prepare('INSERT INTO book_order_items(order_id,book_id,title,quantity,unit_price) VALUES(:order_id,:book_id,:title,:quantity,:unit_price)');
        foreach ($items as $item) {
            $line->execute([
                ':order_id' => $orderId,
                ':book_id' => (int)$item['id'],
                ':title' => $item['title'],
                ':quantity' => (int)$item['quantity'],
                ':unit_price' => number_format((float)$item['price'], 2, '.', ''),
            ]);
        }
        $pdo->commit();
        return true;
    } catch (Throwable $e) {
        if ($pdo instanceof PDO && $pdo->inTransaction()) $pdo->rollBack();
        return false;
    }
}


function projectDossier(string $slug): ?array
{
    try {
        $query = db()->prepare('SELECT p.*, d.problem, d.approach, d.architecture, d.status, d.outcomes, d.repository_url, d.live_url
            FROM projects p LEFT JOIN project_details d ON d.project_id=p.id
            WHERE p.slug=:slug AND p.published=TRUE LIMIT 1');
        $query->execute([':slug'=>$slug]);
        $project=$query->fetch();
        if ($project) {
            $t=db()->prepare('SELECT technology FROM project_technologies WHERE project_id=:id ORDER BY sort_order ASC,id ASC');
            $t->execute([':id'=>(int)$project['id']]);
            $project['technologies']=$t->fetchAll(PDO::FETCH_COLUMN);
            return $project;
        }
    } catch (Throwable $e) {}

    $fallback = [
        'jaslyn-net'=>[
            'name'=>'Jaslyn Net','slug'=>'jaslyn-net','category'=>'Network / ISP / FinTech',
            'summary'=>'A universal connectivity operating fabric connecting payments, service entitlement, identity, network access, sessions, accounting, enforcement and reconciliation.',
            'problem'=>'Build one traceable lifecycle from customer money through service entitlement and network access without duplicating billing, AAA, provisioning or enforcement concepts.',
            'approach'=>'Converge payment, entitlement, identity, RADIUS/AAA, network control, session accounting and reconciliation around shared correlation identity and provider adapters.',
            'architecture'=>'Hybrid connectivity platform with PostgreSQL, API services, Redis-oriented workflows, RADIUS/AAA integration and vendor-neutral network command boundaries.',
            'status'=>'Active development',
            'outcomes'=>'Production-oriented connectivity platform work focused on verified payment-to-access execution, provider-neutral network control and auditable lifecycle reconciliation.',
            'repository_url'=>'https://github.com/yurian51/Jaslyn-Net','live_url'=>null,
            'technologies'=>['Next.js','TypeScript','NestJS','PostgreSQL','Redis','RADIUS','MikroTik','Docker']
        ],
        'yurian-ai-os'=>[
            'name'=>'YURIAN AI OS','slug'=>'yurian-ai-os','category'=>'AI / Software',
            'summary'=>'An AI-native operating environment for knowledge, projects, documents, workflows and intelligent agents.',
            'problem'=>'Keep project context, documents, workflows and intelligent tools connected instead of treating chat as the entire product.',
            'approach'=>'Use explicit agent/tool boundaries, structured outputs and persistent project context with a provider abstraction layer.',
            'architecture'=>'Web application with persistent project data, agent/tool execution boundaries and asynchronous workflows.',
            'status'=>'Active development',
            'outcomes'=>'Ongoing AI-native software, agent, context-management and automation engineering.',
            'repository_url'=>'https://github.com/yurian51/Jaslyn','live_url'=>null,
            'technologies'=>['TypeScript','Next.js','Node.js','PostgreSQL','AI Agents','Tool Calling']
        ],
        'sammena-primary-school'=>[
            'name'=>'Sammena Primary School','slug'=>'sammena-primary-school','category'=>'Education / SIS',
            'summary'=>'A school information and operations system covering admissions, students, academics, fees, reports and school workflows.',
            'problem'=>'Turn recurring school administration into reliable digital workflows while preserving school-specific academic and operational rules.',
            'approach'=>'Model identity, students, admissions, assessments, attendance, fees and reporting as explicit role-aware domains.',
            'architecture'=>'Web application architecture with relational persistence, typed APIs, RBAC and school-scoped data boundaries.',
            'status'=>'Active development',
            'outcomes'=>'Production-oriented SIS work covering public school information and authenticated school operations.',
            'repository_url'=>'https://github.com/yurian51/sammena-school-website','live_url'=>null,
            'technologies'=>['Next.js','TypeScript','PostgreSQL','REST APIs','RBAC']
        ],
        'altavox-technologies'=>[
            'name'=>'Altavox Technologies','slug'=>'altavox-technologies','category'=>'Technology',
            'summary'=>'A technology brand and product ecosystem focused on digital business and software systems.',
            'problem'=>'Create a coherent technology ecosystem that can host multiple digital products without turning them into unrelated systems.',
            'approach'=>'Use a consistent product identity while keeping each product domain explicit and independently maintainable.',
            'architecture'=>'Modular web product architecture with reusable UI, APIs, persistence and integration boundaries.',
            'status'=>'Active development',
            'outcomes'=>'Brand and product engineering across digital business systems, automation and intelligent workflows.',
            'repository_url'=>null,'live_url'=>null,
            'technologies'=>['Web Applications','APIs','PostgreSQL','Automation']
        ]
    ];
    return $fallback[$slug] ?? null;
}

function engineeringDomains(int $limit=20): array
{
    $limit=max(1,min($limit,100));
    try {
        $s=db()->prepare('SELECT * FROM engineering_domains WHERE published=TRUE ORDER BY sort_order ASC,id ASC LIMIT :limit');
        $s->bindValue(':limit',$limit,PDO::PARAM_INT);$s->execute();return $s->fetchAll();
    } catch(Throwable $e) { return [
        ['name'=>'Software Architecture','summary'=>'Designing systems around explicit domains, boundaries, contracts and failure recovery.','technologies'=>'TypeScript · Node.js · NestJS · REST · GraphQL','sort_order'=>1],
        ['name'=>'Full-Stack Engineering','summary'=>'Building production web applications from interface to persistence and deployment.','technologies'=>'Next.js · React · TypeScript · PHP · HTML · CSS','sort_order'=>2],
        ['name'=>'Data & Backend Systems','summary'=>'Designing reliable APIs, relational models, transactions and background workflows.','technologies'=>'PostgreSQL · MySQL · Redis · Prisma · SQL','sort_order'=>3],
        ['name'=>'Network & ISP Platforms','summary'=>'Connecting subscribers, identity, AAA, billing and network enforcement through provider-neutral boundaries.','technologies'=>'MikroTik · RADIUS · PPPoE · Hotspot · IPAM · QoS','sort_order'=>4],
        ['name'=>'FinTech & Payments','summary'=>'Designing verifiable payment lifecycles with idempotency, reconciliation and auditability.','technologies'=>'M-Pesa · Payment APIs · Webhooks · Idempotency','sort_order'=>5],
        ['name'=>'AI & Automation','summary'=>'Building agentic workflows with explicit tools, structured outputs and persistent context.','technologies'=>'AI Agents · Tool Calling · Automation · WebSockets','sort_order'=>6],
        ['name'=>'Infrastructure & Delivery','summary'=>'Packaging, deploying and operating software with observable production boundaries.','technologies'=>'Linux · Docker · NGINX · Render · AWS · CI/CD','sort_order'=>7]
    ]; }
}

function experienceItems(int $limit=20): array
{
    $limit=max(1,min($limit,100));
    try {
        $s=db()->prepare('SELECT * FROM experience WHERE published=TRUE ORDER BY current_role DESC,sort_order ASC,start_date DESC NULLS LAST LIMIT :limit');
        $s->bindValue(':limit',$limit,PDO::PARAM_INT);$s->execute();return $s->fetchAll();
    } catch(Throwable $e) { return [
        ['role'=>'Independent Software Engineer / Product Builder','organization'=>'Yurian','location'=>'Tanzania','start_date'=>'2024-01-01','current_role'=>true,'summary'=>'Designing and building production software across business systems, education platforms, connectivity infrastructure, AI workflows and digital products.','sort_order'=>1],
        ['role'=>'Founder / Technology Builder','organization'=>'YURIAN TECH LTD','location'=>'Tanzania','start_date'=>'2024-01-01','current_role'=>true,'summary'=>'Building software products and technology services with emphasis on full-stack engineering, system architecture and practical delivery.','sort_order'=>2],
        ['role'=>'Founder / Product Builder','organization'=>'Altavox Technologies','location'=>'Tanzania','start_date'=>'2025-01-01','current_role'=>true,'summary'=>'Developing technology products and digital business systems across automation, software platforms and intelligent workflows.','sort_order'=>3]
    ]; }
}

function achievements(int $limit=20): array
{
    $limit=max(1,min($limit,100));
    try {
        $s=db()->prepare('SELECT * FROM achievements WHERE published=TRUE ORDER BY sort_order ASC,id ASC LIMIT :limit');
        $s->bindValue(':limit',$limit,PDO::PARAM_INT);$s->execute();return $s->fetchAll();
    } catch(Throwable $e) { return [
        ['name'=>'Jaslyn Net connectivity lifecycle','category'=>'Network / FinTech','status'=>'active','summary'=>'Payment-to-service-to-network lifecycle with shared correlation and verified enforcement.','progress'=>70,'project_slug'=>'jaslyn-net','sort_order'=>1],
        ['name'=>'Yurian Personal Website','category'=>'Personal Platform','status'=>'active','summary'=>'Engineering portfolio, case-study library, recruiter surface and business interface.','progress'=>75,'project_slug'=>null,'sort_order'=>2],
        ['name'=>'Yurian AI OS','category'=>'AI / Systems','status'=>'active','summary'=>'Persistent context, agent tools and AI-native workflows.','progress'=>45,'project_slug'=>'yurian-ai-os','sort_order'=>3]
    ]; }
}

function buildThreads(int $limit=12): array
{
    $limit=max(1,min($limit,100));
    try {
        $s=db()->prepare('SELECT * FROM build_threads WHERE published=TRUE ORDER BY sort_order ASC,id ASC LIMIT :limit');
        $s->bindValue(':limit',$limit,PDO::PARAM_INT);$s->execute();return $s->fetchAll();
    } catch(Throwable $e) { return []; }
}
