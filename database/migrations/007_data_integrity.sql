ALTER TABLE books
    DROP CONSTRAINT IF EXISTS books_currency_format_check;
ALTER TABLE books
    ADD CONSTRAINT books_currency_format_check
    CHECK (currency = UPPER(currency) AND currency ~ '^[A-Z]{3}$');

ALTER TABLE book_orders
    DROP CONSTRAINT IF EXISTS book_orders_currency_format_check;
ALTER TABLE book_orders
    ADD CONSTRAINT book_orders_currency_format_check
    CHECK (currency = UPPER(currency) AND currency ~ '^[A-Z]{3}$');
