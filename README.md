# Guide d’installation du projet TOMTROC

Ce document explique étape par étape comment installer et exécuter le projet **TOMTROC** en local pour l’évaluation.

---

## Prérequis

Avant de commencer, assurez-vous d’avoir installé :

- **XAMPP** (avec Apache et MySQL)
- Un navigateur web (Chrome, Firefox, etc.)
- **Git** (ou possibilité de télécharger le projet depuis GitHub)

---

## Étapes d’installation

### 1. Récupérer le projet depuis GitHub

Clonez le dépôt GitHub du projet (ou téléchargez-le en ZIP et décompressez-le) :

```bash
https://github.com/MarcoFormante/Tom-Troc.git

```
### 2. Placer le projet dans le dossier htdocs

Copiez le dossier du projet dans le répertoire suivant :

```
C:\xampp\htdocs\

```

Exemple:
```
C:\xampp\htdocs\tomtroc
```
### 3. Démarrer XAMPP

Ouvrez XAMPP Control Panel

Démarrez les services :

- Apache

- MySQL

Vérifiez qu’ils sont bien en cours d’exécution.

### 4. Créer la base de données

Ouvrez phpMyAdmin depuis XAMPP
👉 http://localhost/phpmyadmin

Créez une nouvelle base de données avec le nom suivant :
```
tomtroc
```
### 5. Importer la base de données et les fixtures

 1. Sélectionnez la base de données tomtroc

 2. Cliquez sur l’onglet Importer

 3. Importez le fichier suivant :
```
 tomtroc_DB&fixtures.sql
```

📁 Ce fichier se trouve à la racine du projet.

 4. Validez l’importation et vérifiez que les tables et les données ont bien été créées.


### 6. Vérifier le serveur

Assurez-vous que :

- Apache est démarré

- MySQL est démarré

- Aucun message d’erreur n’apparaît dans XAMPP

## Connexion à l’application (comptes de test)

Pour tester le fonctionnement de l’application, plusieurs **comptes utilisateurs de démonstration** sont déjà disponibles dans la base de données importée.

---

Vous pouvez utiliser l’un des comptes suivants :

- jean.dupont@gmail.com  
- marie.martin@gmail.com  
- pierre.durand@gmail.com  
- sophie.bernard@gmail.com  
- luc.moreau@gmail.com  
- user2026@gmail.com  

👉 **Mot de passe (identique pour tous les utilisateurs) :**
---

### Exemple de connexion 

- **Email :** user2026@gmail.com  
- **Mot de passe :** User2026!


---

Bonne utilisation du projet.