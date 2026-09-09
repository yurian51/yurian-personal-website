# Yurian Personal Website

Production-ready personal brand website built with PHP 8.3, PostgreSQL, Docker and Render.

## Stack
- PHP 8.3
- PostgreSQL
- PDO
- HTML5 / CSS3 / JavaScript
- Docker
- Render

## Structure
- public/ public-facing application
- admin/ CMS dashboard
- config/ database configuration
- includes/ shared PHP services
- database/ SQL schema and seed data
- assets/ CSS, JS and media
- storage/ runtime uploads

## Local development
1. Copy .env.example to .env
2. Configure PostgreSQL
3. Start with Docker Compose
4. Open http://localhost:8080

## Production
Deploy the repository to Render as a Docker Web Service and attach a PostgreSQL database. Never commit real secrets.
