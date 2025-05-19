
# Health Assurance

Ce projet vise à moderniser et automatiser la gestion des données d’assurance maladie dans le secteur public marocain afin d’en améliorer l’efficacité, la précision et la sécurité, tout en facilitant l’accès à l’information pour les parties prenantes.


## 🚀 Run Locally

1. **Installer XAMPP**
   - Téléchargez et installez [XAMPP](https://www.apachefriends.org/index.html) selon votre système d'exploitation.

2. **Lancer XAMPP**
   - Ouvrez le panneau de contrôle XAMPP.
   - Cliquez sur **Start** pour **Apache** et **MySQL**.
   - À côté de **MySQL**, cliquez sur **Admin** pour ouvrir **phpMyAdmin**.

3. **Créer la base de données**
   - Dans **phpMyAdmin**, cliquez sur **"Nouvelle base"** ou **"New"** dans la barre latérale.
   - Nommez votre base de données (ex: `health_db`) et cliquez sur **Créer**.

4. **Importer la base de données**
   - Dans la base créée, allez dans l’onglet **"Importer"**.
   - Cliquez sur **"Choose File"** et sélectionnez le fichier SQL situé dans le dossier `login/database/sql`.
   - Cliquez sur **Exécuter** pour importer les tables et données.

5. **Configurer la connexion à la base**
   - Dans le fichier `dbconfig.php`, personnalisez les informations de connexion à la base de données si nécessaire :
     ```php
     $dbname = "health_db"; // Nom de votre base
     $user = "root";        // Nom d'utilisateur MySQL
     $password = "";        // Mot de passe MySQL (vide par défaut)
     ```

6. **Lancer le site**
   - Copiez le dossier du projet dans `htdocs`, situé dans le dossier XAMPP.
   - Supprimez ou remplacez le `index.php` par défaut si nécessaire.
   - Dans votre navigateur, ouvrez [http://localhost/nom_du_dossier](http://localhost/nom_du_dossier).
   - Cliquez sur le bouton **Login** pour accéder à l’interface de connexion.

7. **Comptes de test**
   Vous pouvez utiliser les comptes suivants selon le rôle :

   | Rôle       | Email                          |
   |------------|--------------------------------|
   | Admin      | admin626@health.ma             |
   | Médecin    | doc683@health.ma               |
   | Pharmacie  | pharma486@health.ma            |
   | Hôpital    | hopital845@health.ma           |
   | Assurance  | assu362@health.ma              |
   | Client     | client637@health.ma            |

   **Mot de passe pour tous :** `BlueTiger42@`  
   > Vous pouvez personnaliser les comptes dans le dossier `login`, selon votre besoin. Chaque rôle possède son propre dossier dédié à son interface et ses fonctionnalités.

---

💡 **Besoin d'aide ?**  
Si vous rencontrez un problème, n'hésitez pas à nous contacter. Nous serons ravis de vous aider à faire fonctionner le projet correctement.


## 🛠️ Tech Stack

### 🧩 Client 
- Tailwind CSS  
- HTML5  
- CSS3  
- Bootstrap4
-[SB Admin 2](https://startbootstrap.com/theme/sb-admin-2) (Admin Dashboard Template)

### 🚀 Server 
- PHP  
- Apache  

### 🗄️ Database
- MySQL  

### 🔧 Tools & Version Control
- Git  
- GitHub  
- XAMPP



## Authors

- Mahta Nouhaila[@Tempestas734](https://github.com/Tempestas734)
- Anice Karim[@Anice-karim](https://github.com/Anice-karim)

