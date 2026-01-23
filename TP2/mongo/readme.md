# TP 2 – MongoDB : Projet **Chopizza**

Ce projet met en œuvre une base de données **NoSQL (MongoDB)** couplée à une application **PHP** afin de gérer le catalogue d'une pizzeria.

---

## Prérequis

Avant de commencer, assurez-vous de disposer des éléments suivants :

* **Docker Desktop** installé et en cours d'exécution
* Un dossier `data/` à la racine du projet contenant :

  * `produits.json`
  * `recettes.json`

---

## Installation et démarrage

### Lancer les conteneurs

Cette commande permet de construire l'image PHP personnalisée et de démarrer les services **MongoDB** et **PHP** en arrière-plan :

```bash
docker-compose up -d --build
```

---

### Installer les dépendances PHP

Installe la bibliothèque `mongodb/mongodb` via **Composer** à l'intérieur du conteneur PHP :

```bash
docker-compose exec php composer install
```

---

### Importer la base de données

Les fichiers JSON sont importés dans la base de données **chopizza**.
Le dossier local `./data` est monté dans `/var/data` côté conteneur.

**Import des produits :**

```bash
docker-compose exec mongo mongoimport \
  --db chopizza \
  --collection produits \
  --file /var/data/produits.json \
  --jsonArray
```

**Import des recettes :**

```bash
docker-compose exec mongo mongoimport \
  --db chopizza \
  --collection recettes \
  --file /var/data/recettes.json \
  --jsonArray
```

---

## Accès à MongoDB

Pour effectuer des requêtes manuelles directement dans la base de données MongoDB :

```bash
docker-compose exec mongo mongosh
```

---

Votre environnement **Chopizza** est maintenant prêt à être utilisé !
