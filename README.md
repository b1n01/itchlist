# Itchlist: a better whishlist 

💢 [https://itchlist.me](Itchlist) is a platform that lets user build and share whishlists build around their social network. 

## Up and running

We are using [laravel homestead](https://laravel.com/docs/5.8/homestead) for local development

## Note

Migration should be run from inside the vagrant machines in order to success

## Keypoints

Una piattaforma che permette di creare whislist, le classiche whishlist compleanni matrimoni ecc... . Però ci sono dei vincoli chiave: è necessario accedere alla piattaforma con un account social, inizialmente solo facebook, e i link devono puntare ad articoli presenti in store online che offrono servizi di affiliazione.
Il primo vincolo ci permette di facilitare la ricerca nella piattaforma: puoi cercare le wishlist di tutti i tuoi amici sui social e inviare loro un invito se non sono presenti nella piattaforma. Il secondo ci permette di dare a chi deve comperare l'articolo uno strumento concreto per l'acquisto, non solo un indicazione del prodotto che deve essere poi cercato in autonomia, inoltre ci permette di guardagnare dai link di affiliazione e poter tenere la piattaforma gratuita e senza pubblicità.

## Functionality

### Base functionality

- Accesso tramite account social network (facebook)
- Aggiunta ed eliminazione di articoli alla propria lista
- Condividere la propria lista con chiunque
- Cercare i propri amici dei social
- Visualizare le wishlist degli amici dei social
- Visualizzare gli articoli aggiunti di recente (senza indicazione del proprietario)
- Eliminazione dell'account

### Later functionallty
- I propri amici devono poter segnare come 'prenotato' un articolo, gli altri amici devono vederlo ma l'interessato no
- Possibilità di 'nascondere' articoli dalla lista
- Possibilità di segnare come ricetuti gli articoli nella lista
- Visualizzare gli articoli più aggiunti / più comprati (senza indicazione del proprietario)
- Visualizzare l'anteprima prima di salvare l'articolo

## DONE
- 'add item' e 'your list' possono essere un unico link
- 'Recently added' probabilmente non è interessante se sei loggato
- Aggiungi $userId.bin2hex(random_bytes(4)) agli user
- Aggiungi 'share your list' alla sezion 'my list'
- Aggiungere delete degli item
- 'join' dovrebbe avvisarti che stai loggando con facebook
- aggiungere un overlay agli item se non sei loggato

## TODO
- Mostrate il popup con sdk javascript di facebook per inviate amici
- limit homepage items
- funzionalità 'book'
- favicon
- aggungi footer con terms & condition
- add coockie consense

## WARNING
- Sempre installare sudo apt-get install php7.2-curl altrimenti facebook graph-sdk cerca di utilizzare guzzle 5
ma laravel richiede il 6 e si rompe
- Semplre installase sudo apt-get install php7.2-mbstring