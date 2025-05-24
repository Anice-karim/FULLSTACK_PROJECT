# Health Assurance

Ce projet vise à moderniser et automatiser la gestion des données d’assurance maladie dans le secteur public marocain afin d’en améliorer l’efficacité, la précision et la sécurité, tout en facilitant l’accès à l’information pour les parties prenantes.

## 🚀 Run Localement

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

6. **Installer MailHog (simulateur SMTP)**  
   - Rendez-vous sur [MailHog GitHub](https://github.com/mailhog/MailHog) ou installez via `go` (si installé) :  
     ```bash
     go install github.com/mailhog/MailHog@latest
     ```  
   - Ou téléchargez la version Windows `.exe` depuis : [https://github.com/mailhog/MailHog/releases](https://github.com/mailhog/MailHog/releases)  
   - Décompressez et placez le fichier `MailHog.exe` dans un dossier accessible.  
   - **Important :** Double-cliquez sur `MailHog.exe` pour le lancer à chaque fois que vous travaillez sur l'application.  
   - MailHog sera accessible sur : [http://localhost:8025](http://localhost:8025)

7. **Configurer PHP pour MailHog et GD**  
   - Ouvrez le fichier `php.ini` (dans XAMPP, généralement `C:\xampp\php\php.ini`).  
   - **Activer l’extension GD** :  
     Trouvez la ligne  
     ```ini
     ;extension=gd
     ```  
     et décommentez-la :  
     ```ini
     extension=gd
     ```  
   - **Configurer SMTP pour MailHog** :  
     Ajoutez ou modifiez les lignes suivantes :  
     ```ini
     SMTP = localhost  
     smtp_port = 1025  
     sendmail_from = admin@test.com
     ```  
   - Enregistrez et redémarrez Apache via le panneau XAMPP.

8. **Lancer le site**  
   - Copiez le dossier du projet dans `htdocs`, situé dans le dossier XAMPP.  
   - Supprimez ou remplacez le `index.php` par défaut si nécessaire.  
   - Dans votre navigateur, ouvrez [http://localhost/nom_du_dossier](http://localhost/nom_du_dossier).  
   - Cliquez sur le bouton **Login** pour accéder à l’interface de connexion.

9. **Compte de test**  
   | Rôle  | Email           | Mot de passe   |  
   |-------|-----------------|---------------|  
   | Admin | Admin@test.com  | BlueTiger42@  |  

   > Vous pouvez personnaliser ce compte dans le dossier `login` selon vos besoins.

---

💡 **Besoin d'aide ?**  
Si vous rencontrez un problème, n'hésitez pas à nous contacter. Nous serons ravis de vous aider à faire fonctionner le projet correctement.

---

## 🛠️ Tech Stack

### 🧩 Client  
- Tailwind CSS  
- HTML5  
- CSS3  
- Bootstrap4  
- [SB Admin 2](https://startbootstrap.com/theme/sb-admin-2) (Admin Dashboard Template)

### 🚀 Server  
- PHP  
- Apache  

### 🗄️ Database  
- MySQL  

### 🔧 Tools & Version Control  
- Git  
- GitHub  
- XAMPP  
- MailHog




## Authors

- Mahta Nouhaila[@Tempestas734](https://github.com/Tempestas734)
- Anice Karim[@Anice-karim](https://github.com/Anice-karim)

