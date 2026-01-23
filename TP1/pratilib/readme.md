# Installation du projet Praticien

Ce document décrit les étapes nécessaires pour installer et lancer le projet à l’aide de Docker.

---

## Prérequis

* Docker et Docker Compose installés
* Les fichiers suivants disponibles dans le projet :

  * `.env.dist`
  * `prati.schema.sql`
  * `prati.data.sql`

---

## Installation et démarrage

### 1. Configuration de l’environnement

Transformer le fichier `.env.dist` en `.env` avec la commande suivante :

```bash
cp .env.dist .env
```

---

### 2. Lancement des conteneurs

Démarrer les services Docker en arrière-plan :

```bash
docker-compose up -d
```

---

### 3. Accès à l’interface web

Ouvrir un navigateur et se rendre à l’adresse suivante :

```
http://localhost:8080/
```

Renseigner les identifiants présents dans le fichier `prat.env` en prenant en compte les paramètres suivants :

* Serveur : `praticien.db`
* Système de base de données : PostgreSQL

---

### 4. Exécution des scripts SQL

Dans l’interface, accéder à la section **Requête SQL** puis :

1. Copier le contenu du fichier `prati.schema.sql` dans le dossier `sql`
2. Exécuter le script
3. Répéter la même opération avec le fichier `prati.data.sql`

---

### 5. Accès final à l’application

Une fois l’installation terminée, accéder à l’application à l’adresse suivante :

```
http://localhost:3080/
```

---

L’application est maintenant prête à être utilisée.
