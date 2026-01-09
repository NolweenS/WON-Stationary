# WON-Stationary - Laravel E-commerce Project

Een moderne e-commerce webapplicatie voor stationary producten, gebouwd met Laravel 11 en Tailwind CSS.

## Over het Project

WON-Stationary is een full-stack e-commerce platform voor het verkopen van kantoorartikelen en stationary producten. Het project omvat een gebruikersvriendelijke frontend voor klanten en een uitgebreid admin panel voor beheer.

## Vereisten

- PHP >= 8.2
- Composer >= 2.6
- Node.js >= 18.x
- NPM >= 9.x
- MySQL >= 8.0
- Git

## Installatie

### Stap 1: Clone de Repository

```bash
git clone https://github.com/jouw-username/won-stationary.git
cd won-stationary
```

### Stap 2: Installeer PHP Dependencies

```bash
composer install
```

### Stap 3: Installeer JavaScript Dependencies

```bash
npm install
```

### Stap 4: Kopieer Environment File

```bash
# Windows (Command Prompt)
copy .env.example .env

# Linux/Mac (Terminal)
cp .env.example .env
```

### Stap 5: Genereer Application Key

```bash
php artisan key:generate
```

## Configuratie

### Database Configuratie

Open het `.env` bestand en pas de database instellingen aan:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=won_stationary
DB_USERNAME=root
DB_PASSWORD=
```

### Mail Configuratie (Optioneel)

Voor email functionaliteit (zoals registratie bevestigingen):

```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@won-stationary.test
MAIL_FROM_NAME="WON-Stationary"
```

## Database Setup

### Stap 1: Maak de Database aan

Maak een nieuwe database aan in MySQL:

```sql
CREATE DATABASE won_stationary CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### Stap 2: Run Migrations en Seeders

Dit commando maakt alle tabellen aan en vult ze met test data:

```bash
php artisan migrate:fresh --seed
```

### Stap 3: Create Storage Link

Maak een symbolische link voor het opslaan van geüploade afbeeldingen:

```bash
php artisan storage:link
```

### Stap 4: Build Frontend Assets

Compileer de Tailwind CSS en JavaScript:

```bash
npm run build
```

Voor development met hot-reload:

```bash
npm run dev
```

### Stap 5: Start de Development Server

```bash
php artisan serve
```

De applicatie is nu beschikbaar op: `http://localhost:8000`

## Login Credentials

### Admin Account

```
Email: admin@ehb.be
Password: Password!321
```

## Features

### Basis Functionaliteit

**Product Management**
- Volledig CRUD systeem voor producten
- Productcategorieën met filtering
- Afbeelding upload functionaliteit
- Voorraad beheer
- Prijsbeheer met kortingen

**Categorie Systeem**
- 5 hoofdcategorieën: Planners, Notebooks, Pens & Crayons, Stickers, Accessoires
- Categorieën met beschrijvingen en slugs
- Producten gelinkt aan categorieën

**Nieuws Sectie**
- Dynamische nieuwsartikelen
- Rich text content
- Auteur attributie
- Publicatiedatum beheer
- Featured images

**FAQ Systeem**
- FAQ categorieën voor organisatie
- Vraag en antwoord beheer
- Sorteerbare volgorde
- Zoekfunctionaliteit

### Gebruikersfuncties

**Authenticatie**
- Gebruikersregistratie met email verificatie
- Secure login systeem
- Password reset functionaliteit

**User Dashboard**
- Persoonlijk overzicht
- Profielbewerking
- Bestellingshistorie
- Wishlist beheer

**Wishlist**
- Producten opslaan voor later
- Eenvoudig toevoegen/verwijderen
- Overzicht van opgeslagen items
- sturen vie de link naar vrienden/familie

**Review Systeem**
- Producten beoordelen met sterren (1-5)
- Reviews schrijven met titel en tekst
- Verified purchase badge
- Helpful counter
- Review bewerking en verwijdering

**Bestellingen**
- Volledige orderhistorie
- Order status tracking
- Order details met items
- Factuur informatie

**Profielen**
- berichten versturen naar gebruikers in het profiel gastenboek


### Admin Functionaliteit

**Admin Dashboard**
- Overzicht statistieken
- Recente bestellingen
- Product voorraad monitoring
- Gebruikersactiviteit

**Product Beheer**
- Producten toevoegen, bewerken, verwijderen
- Bulk acties
- Afbeelding upload
- Categorie toewijzing
- Voorraad updates

**Nieuws Beheer**
- Nieuwsartikelen aanmaken en bewerken
- Featured image upload
- Publicatiestatus
- SEO-vriendelijke slugs

**FAQ Beheer**
- FAQ categorieën beheren
- Vragen toevoegen en bewerken
- Volgorde aanpassen
- Zoeken en filteren

**User Management**
- Gebruikers overzicht
- Account status beheer

### Design & UX

**Responsive Design**
- Volledig mobielvriendelijk


**Kleurenschema**
- Warm, aards palet met beige en bruintinten
- Consistent design systeem
- Toegankelijke contrasten

**Componenten**
- Herbruikbare Blade components
- Product cards
- Review cards
- Star rating component
- Alert notifications
- Button variants
- Navigation components
- Footer

### Extra Features

**Zoek & Filter**
- Real-time zoeken in producten
- Filteren op categorie
- Filteren op prijsrange
- Filteren op voorraad status
- Sorteren op prijs, naam, populariteit

**Validatie**
- Server-side validatie voor alle forms
- Client-side feedback
- Custom error messages
- Input sanitization

**Beveiliging**
- CSRF protection
- XSS prevention
- SQL injection protection
- Password hashing met bcrypt
- Rate limiting op login


## Technologieën

### Backend
- Laravel 11
- PHP 8.4
- MySQL 8.0
- Eloquent ORM

### Frontend
- Tailwind CSS 3.0
- Alpine.js
- Blade Templates
- Vite

### Development Tools
- Composer
- NPM
- Git
- Laravel Breeze (Authentication)

### Testing Tools
- Mailtrap (Email testing)

## Bronvermeldingen

### Documentatie & Tutorials

**Laravel**
- Laravel Official Documentation: https://laravel.com/docs
  Gebruikt voor: Alle Laravel functionaliteit, best practices, en feature implementatie

- Laracasts: https://laracasts.com
  Gebruikt voor: Video tutorials over Laravel concepts, Eloquent relationships, en authentication

- Laravel Daily (YouTube): https://www.youtube.com/@LaravelDaily
  Gebruikt voor: Praktische voorbeelden van Laravel features en code snippets

### AI Assistentie

**Claude AI (Anthropic)**
- Gebruikt voor ondersteuning van projectontwikkeling
- Specifieke hulp bij: Seeder implementatie, Blade component structuur, validatie logica

### Tools

**Postman**
- Website: https://www.postman.com
- Gebruikt voor: API endpoint testing en debugging

**Mailtrap**
- Website: https://mailtrap.io
- Gebruikt voor: Email testing in development omgeving

### Design Resources

**Tailwind CSS**
- Website: https://tailwindcss.com
- Gebruikt voor: Styling en responsive design

**Google Fonts (Bunny Fonts CDN)**
- Fonts: Cormorant (serif), Inter (sans-serif)
- Gebruikt voor: Typografie in het project

## Licentie

Dit project is gemaakt voor educatieve doeleinden als onderdeel van een schoolproject.
