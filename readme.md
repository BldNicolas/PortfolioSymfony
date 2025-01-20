# README.md

# Cyberfolio - Portfolio en Symfony

## À propos du projet
Ce projet consiste en la création d'un générateur de portfolio en ligne (cyberfolio) utilisant le framework Symfony. L'objectif est de créer une plateforme permettant aux utilisateurs de créer et gérer leurs portfolios pour présenter leur parcours professionnel, leurs formations et leurs réalisations de manière dynamique et évolutive.

## Accès à l'application
- URL : http://127.0.0.1:8000/
- Identifiant admin : admin@mail.com
- Mot de passe admin : password1

## État d'avancement
- ✅ Système d'authentification implémenté
- ✅ Gestion des portfolios par utilisateur
- ✅ Vue des expériences
- ✅ Système de sécurisation des routes
- ✅ Export de la base de données
- ✅ Configuration de base (.env.local)
- ⏳ AssetMapper en cours d'implémentation

## Difficultés rencontrées et solutions
### Difficultés :
- Mise en place du SecurityBundle pour la gestion de l'authentification
- Gestion des droits d'accès aux différentes sections du portfolio
- Configuration de l'AssetMapper
- Refactorisation majeure du projet pour passer d'un portfolio éditable à un générateur de portfolios
- Restructuration complète de la base de données pour accommoder le nouveau concept

### Solutions :
- Utilisation de la documentation officielle de Symfony pour le SecurityBundle
- Implémentation d'un système de vérification des droits utilisateur
- Création d'un nouveau schéma de base de données avec des relations adaptées au concept de générateur
- Migration des données existantes vers la nouvelle structure

## Acquis
- Maîtrise du framework Symfony
- Gestion de l'authentification et des autorisations
- Structuration d'une application web complexe
- Manipulation des entités et des relations en Doctrine
- Capacité à pivoter et refactoriser un projet en cours de développement
- Gestion de la migration de données lors d'une restructuration majeure

## Remarques supplémentaires
- Les données sont stockées dans ./data/
- Le concept a évolué vers un générateur de portfolios, offrant plus de flexibilité aux utilisateurs
- La nouvelle architecture permet la création de multiples portfolios par utilisateur