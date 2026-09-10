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
