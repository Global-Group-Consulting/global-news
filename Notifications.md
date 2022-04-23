# Notifications
Questa applicazione riceverà le varie notifiche e le esporrà agli utenti tramite api.
Ogni utente dovrà chiedere a quest'app la lista delle notifiche 
e la conferma di lettura verrà gestita sempre da quest'app.

## Logica
Ogni app che deve inviare una notifica, contatta il server delle code e inserisce una richiesta
di notifica. La coda, quando elabora la richiesta, comunica a questo server delle notifiche, i dati
relativi e il server, una volta ricevuti i dati, si occupa di salvarli a db.

App -> Queue -> NewsENotifiche

Ogni notifica deve avere una tipologia ed un campo "receivers" dove inserire i destinatari di quella notifica.
Questo sarà utile nel caso si voglia lanciare una notifica globale o solo per un gruppo di persone.

Ad ogni notifica occorre aggiungere un campo "readings" in modo da salvare ogni volta che qualcuno la legge.

Aggiungere anche un campo status per indicare se deve essere mostrata o se è completata e non serve più. 
Diventa completata quando l'utente destinatario la legge o quando tutti gli utenti destinatari la leggono.

## Socket
L'app dovrebbe esporre un websocket a cui le app si possano collegare per ricevere in tempo reale
le nuove notifiche

## MultiTenant
L'app ricevere le notifiche di qualsiasi app, quindi è necessario indicare il tenant di ogni notifica.
Per fare questo, occorre quindi aggiungere un campo ad ogni notifica dove indicare a quale
app fa riferimento.
