# BNC Social Network (PHP 8 MVC)

Plateforme SaaS de réseau social professionnel (style LinkedIn) développée en **PHP natif orienté objet**.

## 1) Architecture

- `public/` : point d'entrée unique, assets, `.htaccess`.
- `app/Core/` : kernel MVC (Router, Request/Response, DB PDO, Session, CSRF, Auth, View, Env, ErrorHandler).
- `app/Controllers/` : logique HTTP par domaine (auth, feed, profile, network, messages, companies, jobs, admin, api).
- `app/Models/` : accès DB via PDO + requêtes préparées.
- `app/Views/` : templates PHP séparés par feature.
- `routes/web.php` : définition de routes centralisée.
- `config/app.php` + `.env` : configuration runtime.
- `database/schema.sql` : schéma MySQL complet + seeds.
- `storage/logs/` : logs applicatifs.

## 2) Installation

### Prérequis
- PHP 8.1+
- MySQL 8+
- Apache ou Nginx

### Étapes
1. Copier la config:
   ```bash
   cp .env.example .env
   ```
2. Créer la DB:
   ```bash
   mysql -u root -p < database/schema.sql
   ```
3. Mettre à jour `.env` avec vos credentials MySQL.
4. Démarrer en local:
   ```bash
   php -S localhost:8000 -t public
   ```
5. Ouvrir `http://localhost:8000`.

Comptes seed (mot de passe hash pour exemple, utilisez la réinitialisation/inscription):
- `admin@bnc.local`
- `alice@bnc.local`
- `recruiter@bnc.local`

## 3) Sécurité implémentée
- Hashage des mots de passe: `password_hash` / `password_verify`.
- Sessions sécurisées (HttpOnly, SameSite, rotation ID).
- Protection CSRF globale via token.
- Prévention injection SQL via PDO prepared statements.
- Prévention XSS avec `htmlspecialchars` + `strip_tags`.
- Rôles: `user`, `recruiter`, `admin`.
- Vérification email par token.

## 4) Fonctionnalités livrées
- Authentification (inscription/connexion/vérification).
- Profil éditable (headline/bio/localisation/site, base extensible avatar/banner).
- Fil d'actualité (création de post + visibilité + pagination serveur).
- Suggestions de connexions (algorithme simple).
- Messagerie (squelette + structure DB complète).
- Entreprises / offres / candidatures (structure DB + pages dédiées).
- Notifications centralisées + endpoint AJAX `/api/notifications`.
- Admin panel (accès restreint rôle admin).
- Front responsive moderne + soumission AJAX.
- Structure prête pour API REST interne et scalabilité.

## 5) Apache / Nginx
- Apache: utiliser `public/.htaccess`.
- Nginx: exemple dans `scripts/nginx.conf.example`.

## 6) Scalabilité & microservices
- Couche Core indépendante du domaine.
- Séparation stricte Controller/Model/View.
- Domaines prêts à être extraits (auth, messaging, jobs, notifications).
- Schéma DB normalisé et indexé pour montée en charge.

## 7) Roadmap bonus
- Premium subscriptions (`users.premium_until` prêt).
- Statistiques de profils (`profiles.profile_views` prêt).
- Mode sombre (`profiles.dark_mode` prêt).
- Internationalisation (`profiles.locale` prêt).
