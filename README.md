# 🦁 Zoo Site

Bienvenue sur **Zoo Site**, une application web conçue pour gérer un parc zoologique avec des fonctionnalités complètes pour les visiteurs, employés, vétérinaires et administrateurs.  
Ce projet a été réalisé dans le cadre d’un ECF et couvre toute la chaîne de création : analyse, conception, développement, déploiement.

---

## 📌 Objectif

Offrir une application ergonomique permettant :
- aux visiteurs de découvrir les habitats, les animaux, les services, et de laisser des avis ;
- aux vétérinaires de suivre la santé des animaux ;
- aux employés de gérer la nourriture et les avis ;
- à l’administrateur de gérer le parc et d’avoir une vue statistique complète.

---

## 🧩 Fonctionnalités par US

### ✅ US 1 : Page d’accueil
- Présentation du zoo, avec images
- Liste des habitats, services et animaux
- Affichage des avis validés

### ✅ US 2 : Menu principal
- Navigation intuitive :
  - Accueil
  - Habitats
  - Services
  - Connexion (pour employés, vétérinaires, admin uniquement)
  - Contact

### ✅ US 3 : Vue des services
- Affiche tous les services : nom + description
- Les services sont gérés depuis l’espace administrateur

### ✅ US 4 : Vue des habitats
- Liste de tous les habitats avec leurs images
- Détail d’un habitat :
  - Description
  - Liste des animaux
  - État de santé de chaque animal

### ✅ US 5 : Avis visiteurs
- Possibilité de laisser un avis (pseudo + texte)
- L’avis est soumis à validation par un employé
- Une fois validé, l’avis s’affiche sur la page d’accueil

### ✅ US 6 : Espace Administrateur
- Création de comptes employés / vétérinaires (email + mot de passe)
- Gestion complète du parc (CRUD) : services, horaires, habitats, animaux
- Dashboard avec statistiques (US 11)
- Accès à tous les comptes rendus des vétérinaires avec filtres

### ✅ US 7 : Espace Employé
- Valide ou invalide les avis
- Ajoute les rations alimentaires pour chaque animal

### ✅ US 8 : Espace Vétérinaire
- Saisie des bilans de santé des animaux
- Ajoute un commentaire sur un habitat
- Voit l’historique alimentaire d’un animal

### ✅ US 9 : Connexion
- Connexion via email + mot de passe
- Seuls les vétérinaires, employés et administrateurs ont un accès

### ✅ US 10 : Contact
- Formulaire : titre, description, email
- Envoie un mail au zoo, réponse par mail

### ✅ US 11 : Statistiques
- Chaque clic sur un animal augmente un compteur de consultation
- Les données sont stockées dans MongoDB (non relationnelle)
- Visualisation dans le dashboard admin

---

## 🧪 Technologies utilisées

- **Back-end** : PHP 8, XAMPP
- **Base de données relationnelle** : MySQL
- **Base de données non-relationnelle** : MongoDB (pour les statistiques)
- **Front-end** : HTML / CSS / JS (sans framework JS pour l'instant)
- **Mailer** : PHPMailer
- **Composer** : Gestion des dépendances PHP
- **Git** : Suivi de version
- **Trello** : Suivi du projet
- **MongoDB Compass** : Interface graphique pour MongoDB
- **Deploiement**: Heroku https://zoo-site-heroku-eb2d5581e91f.herokuapp.com/

---

## 🚀 Lancer le projet en local

### 1. Cloner le dépôt

```bash
git clone https://github.com/SekouKo/zoo_site.git
cd zoo_site

