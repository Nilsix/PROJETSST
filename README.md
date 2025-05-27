# Application de Gestion des Agents

## 📋 Description

Application web développée avec Laravel pour la gestion des agents, offrant différentes fonctionnalités selon le niveau d'accès de l'utilisateur.

## 🛠️ Prérequis

- PHP 8.1 ou supérieur
- Composer
- Node.js et NPM
- Base de données MariaDB/MySQL
- Serveur web (Apache/Nginx)

## 🚀 Installation

1. **Cloner le dépôt**
   ```bash
   git clone [URL_DU_REPO]
   cd PROJETSST
   ```

2. **Installer les dépendances PHP**
   ```bash
   composer install
   ```

3. **Installer les dépendances JavaScript**
   ```bash
   npm install
   npm run dev
   ```

4. **Configurer l'environnement**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configurer la base de données**
   - Créer une base de données MySQL/MariaDB nommée `dbsst`
   - Configurer les informations de connexion dans le fichier `.env`

6. **Exécuter les migrations et les seeders**
   ```bash
   php artisan migrate --seed
   ```

7. **Lancer le serveur de développement**
   ```bash
   php artisan serve
   ```

## 🔐 Structure d'authentification

### Rôles et permissions

- **Vision = 1** : Utilisateur local (accès limité à son site d'affectation)
- **Vision = 2** : Gestionnaire global (accès à tous les agents)
- **Vision = 3** : Administrateur (accès complet, y compris la gestion des utilisateurs)

## 🗃️ Structure de la base de données

### Table `users`
- `id` : Identifiant unique
- `name` : Nom complet de l'utilisateur
- `email` : Adresse email (unique)
- `password` : Mot de passe chiffré
- `vision` : Niveau d'accès (1-3)
- `numAgent` : Numéro d'agent lié
- `created_at` / `updated_at` : Horodatages

### Table `agents`
- `id` : Identifiant unique
- `numAgent` : Numéro d'agent (unique)
- `created_at` / `updated_at` : Horodatages

## 🔄 API Externe

L'application se connecte à une API externe pour récupérer les informations détaillées des agents via leur numéro d'agent.

## 🛡️ Sécurité

- Authentification Laravel avec hachage des mots de passe
- Protection CSRF sur tous les formulaires
- Middleware d'authentification sur les routes sensibles
- Vérification des autorisations avec les Gates Laravel
- Protection contre les injections SQL avec l'ORM Eloquent

## 📝 Fonctionnalités

### Gestion des agents
- Consultation de la liste des agents
- Ajout d'un nouvel agent
- Lecture des informations d'un agent
- Suppression d'un agent

### Gestion des utilisateurs
- Création de comptes utilisateurs
- Attribution des niveaux d'accès
- Gestion des profils utilisateurs

## 🏗️ Architecture

- **Framework** : Laravel 10.x
- **Base de données** : MariaDB/MySQL
- **Frontend** : Bootstrap 5, jQuery
- **Authentification** : Laravel Breeze
- **API** : Client HTTP intégré de Laravel

## 📄 Licence

Ce projet est sous licence MIT. Voir le fichier `LICENSE` pour plus de détails.

## ✨ Contribution

Les contributions sont les bienvenues ! N'hésitez pas à ouvrir une issue ou une pull request.
