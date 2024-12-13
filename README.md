# Pràctica de Backend pr5

## Descripció del projecte
Aquesta pràctica consisteix en la creació d'una aplicació web senzilla per gestionar articles utilitzant PHP i MySQL.
La web consisteix en gestor de vehicles a mecanics administrador de garatges de diferents ciutats ,aquesta permet als usuaris registrar les seves dades i pujar vehicles associats a ells. Utilitza una base de dades MySQL i està desenvolupada amb PHP i HTML/CSS. Els articles es componen de diversos camps, incloent marca, model, color, matrícula i imatge, i ara inclou funcionalitats de Paginació, Sessions i Cookies per millorar l'experiència de l'usuari.


## Funcionalitats implementades
1. **Connexió a la Base de Dades**: Connexió segura i manejable amb PDO.
2. **Registre d'Usuaris**: Possibilitat d'inserir usuaris a la base de dades amb un sistema de registre.
3. **Login d'Usuaris**: Implementació d'un sistema de login per a que els usuaris puguin accedir a les seves comptes.
4. **Gestió de Sessions**: Utilització de sessions per mantenir l'estat d'ús dels usuaris i personalitzar l'experiència.
5. **Cookies**: S'han fet servir cookies per recordar preferències dels usuaris i millorar la personalització.
6. **Inserció d'Articles**: Permetre als usuaris afegir articles amb imatges associades.
7. **Visualització d'Articles**: Mostrar articles a la interfície amb detalls i paginació.
8. **Paginació d'Articles**: Navegació entre diferents pàgines d'articles.
9. **Estil i Disseny**: Interfície d'usuari millorada amb CSS.
10. **Comprovacions d'errors**: Gestió d'errors durant la inserció d'articles i usuaris.


## Instal·lació i Ús
1. **Requisits**
   - PHP (versió 7.0 o superior)
   - MySQL (versió 5.7 o superior)
   - Un servidor local com XAMPP, WAMP o MAMP.
2. **Configuració de la Base de Dades**
   - Executar el script SQL proporcionat per crear la base de dades i les taules.
3. **Pujar Fitxers**
   - Col·locar els fitxers PHP i CSS al directori del teu servidor localhost.
4. **Accedir al Projecte**
   - Obrir el navegador i accedir a `http://localhost`.
5. **Reemplaçar l'env example**
   - Renombrar el fitxer `env-example.php` a `env.php` i afegir els parametres propis dins d'aquest.

