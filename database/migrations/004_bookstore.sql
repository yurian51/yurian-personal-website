CREATE TABLE IF NOT EXISTS books (
 id BIGSERIAL PRIMARY KEY,
 title VARCHAR(220) NOT NULL,
 slug VARCHAR(220) UNIQUE NOT NULL,
 author VARCHAR(180) NOT NULL,
 description TEXT NOT NULL,
 price NUMERIC(10,2) NOT NULL CHECK (price >= 0),
 currency VARCHAR(3) NOT NULL DEFAULT 'USD',
 cover_url TEXT,
 stock_quantity INT NOT NULL DEFAULT 0 CHECK (stock_quantity >= 0),
 featured BOOLEAN NOT NULL DEFAULT FALSE,
 published BOOLEAN NOT NULL DEFAULT TRUE,
 sort_order INT NOT NULL DEFAULT 0,
 created_at TIMESTAMPTZ NOT NULL DEFAULT NOW()
);

CREATE TABLE IF NOT EXISTS book_orders (
 id BIGSERIAL PRIMARY KEY,
 customer_name VARCHAR(160) NOT NULL,
 customer_email VARCHAR(255) NOT NULL,
 notes TEXT,
 total_amount NUMERIC(10,2) NOT NULL CHECK (total_amount >= 0),
 currency VARCHAR(3) NOT NULL DEFAULT 'USD',
 status VARCHAR(30) NOT NULL DEFAULT 'inquiry',
 created_at TIMESTAMPTZ NOT NULL DEFAULT NOW()
);

CREATE TABLE IF NOT EXISTS book_order_items (
 id BIGSERIAL PRIMARY KEY,
 order_id BIGINT NOT NULL REFERENCES book_orders(id) ON DELETE CASCADE,
 book_id BIGINT REFERENCES books(id) ON DELETE SET NULL,
 title VARCHAR(220) NOT NULL,
 quantity INT NOT NULL CHECK (quantity > 0),
 unit_price NUMERIC(10,2) NOT NULL CHECK (unit_price >= 0)
);

CREATE INDEX IF NOT EXISTS idx_books_published_featured ON books(published,featured,sort_order);
CREATE INDEX IF NOT EXISTS idx_book_orders_created ON book_orders(created_at DESC);

INSERT INTO books(title,slug,author,description,price,currency,stock_quantity,featured,sort_order)
VALUES
('The Interface Is Part of the Model','interface-is-part-of-the-model','Yurian Mwangi','A working book about making intelligent systems legible, negotiable, and useful.',18.00,'USD',12,TRUE,1),
('Building With a Longer Horizon','building-with-a-longer-horizon','Yurian Mwangi','Notes on defaults, recovery paths, clear language, and software people can trust.',15.00,'USD',8,TRUE,2),
('Things That Changed How I Make','things-that-changed-how-i-make','Yurian Mwangi','A compact reading and making list for builders who want to keep paying attention.',12.00,'USD',20,FALSE,3)
ON CONFLICT (slug) DO NOTHING;
