# Annuaire Sportif C'Chartres

Projet Symfony d'annuaire des sportifs de la ville de Chartres.

## 📋 Prérequis

- PHP 8.1+
- Composer
- MySQL/MariaDB
- Symfony CLI (optionnel)

## 🚀 Installation

### 1. Cloner le projet

```bash

git clone <url-du-repository>
cd AnnuaireSportif

```

### 2. Installer les dépendances

```bash

composer install

```

### 3. Configuration de la base de données

Copier le fichier `.env.example` vers `.env` et modifier la ligne `DATABASE_URL` :

```env
DATABASE_URL="mysql://utilisateur:motdepasse@127.0.0.1:3306/annuaire?serverVersion=10.11.2-MariaDB&charset=utf8mb4"
```

### 4. Créer la base de données

```bash

php bin/console doctrine:database:create 

```

### 5. Créer les tables

```bash

php bin/console doctrine:migrations:migrate

```

### 6. Charger les fixtures

```bash

php bin/console doctrine:fixtures:load

```

Cette commande chargera les données de test suivantes :
- 3 catégories sportives (Football, Handball, Basketball)
- 4 niveaux (Ligue 1, Ligue 2, National, Régional)
- 2 utilisateurs (1 admin, 1 user)
- 4 joueurs
- 2 avis

## 🔐 Comptes de test

### Administrateur
- **Email** : `admin@example.com`
- **Mot de passe** : `admin`

### Utilisateur
- **Email** : `user@example.com`
- **Mot de passe** : `user`

## ▶️ Lancement du serveur

### Avec Symfony CLI
```bash
symfony server:start
```

### Avec PHP
```bash

php -S localhost:8000 -t public

```

Le site sera accessible sur http://localhost:8000

## 📁 Structure du projet

```
src/
├── Controller/
│   ├── HomeController.php          # Page d'accueil
│   ├── PlayerController.php        # Détail joueur
│   ├── SecurityController.php      # Authentification
│   ├── ReviewController.php        # Gestion des avis
│   └── Admin/
│       ├── CategoryController.php  # CRUD Catégories
│       ├── LevelController.php     # CRUD Niveaux
│       └── PlayerAdminController.php # CRUD Joueurs
├── Entity/
│   ├── User.php
│   ├── Player.php
│   ├── Category.php
│   ├── Level.php
│   └── Review.php
├── Form/
│   ├── RegistrationType.php
│   ├── PlayerType.php
│   ├── ReviewType.php
│   ├── CategoryType.php
│   └── LevelType.php
└── Repository/
```

## 🎯 Fonctionnalités

### Pages publiques
- ✅ Page d'accueil avec liste des joueurs
- ✅ Page détail d'un joueur avec ses avis
- ✅ Note moyenne calculée automatiquement

### Authentification
- ✅ Inscription
- ✅ Connexion
- ✅ Déconnexion

### Espace Utilisateur (ROLE_USER)
- ✅ Créer un avis sur un joueur
- ✅ Voir ses propres avis
- ✅ 1 seul avis par joueur et par utilisateur

### Espace Admin (ROLE_ADMIN)
- ✅ CRUD complet pour les Catégories
- ✅ CRUD complet pour les Niveaux
- ✅ CRUD complet pour les Joueurs

## 🗺️ Routes principales

- `/` - Page d'accueil
- `/login` - Connexion
- `/register` - Inscription
- `/player/{id}` - Détail joueur
- `/player/{id}/review` - Ajouter un avis (connecté)
- `/my-reviews` - Mes avis (connecté)
- `/admin/category` - Gestion catégories (admin)
- `/admin/level` - Gestion niveaux (admin)
- `/admin/player` - Gestion joueurs (admin)

## 🛠️ Technologies utilisées

- Symfony 7.x
- Doctrine ORM
- Twig
- Symfony Security
- Symfony Forms

## 👥 Auteurs

Projet réalisé dans le cadre du devoir Symfony - Annuaire Sportif C'Chartres
