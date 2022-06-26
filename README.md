# Itchlist: a better whishlist 

💢 [https://itchlist.b1n01.com](Itchlist) is a platform that lets user build and share whishlists build around their social network. 

## Up and running

Uses using [laravel homestead](https://laravel.com/docs/5.8/homestead) for local development

## Note

Migration should be run from inside the vagrant machines in order to success

## Keypoints

A platform that allows you to create whislists, the classic whishlists, birthdays, weddings, etc .... However, there are key constraints: it is necessary to access the platform with a social account, initially only facebook, and the links must point to articles in online stores that offer affiliate services. The first constraint allows us to facilitate the search on the platform: you can search the wishlists of all your friends on social networks and send them an invitation if they are not present on the platform. The second allows us to give those who have to buy the article a concrete tool for the purchase, not just an indication of the product that must then be searched independently, it also allows us to guard against affiliate links and be able to keep the platform free. and without advertising.

## Functionality

### Base functionality

- Access via social network account (facebook)
- Adding and deleting articles to your list
- Share your list with anyone
- Search for your friends on social networks
- View the wishlists of friends on social networks
- View recently added items (without owner indication)
- Deletion of the account

### Later functionallty
- Your friends must be able to mark an article as 'booked', other friends must see it but the interested party cannot
- Ability to 'hide' items from the list
- Ability to mark items in the list as received
- View the most added / most bought items (without indication of the owner)
- Preview before saving the article

## DONE
- 'add item' and 'your list' can be a single link
- 'Recently added' is probably not interesting if you are logged in
- Add $ userId.bin2hex (random_bytes (4)) to users
- Add 'share your list' to the 'my list' section
- Add delete items
- 'join' should warn you that you are logging in with facebook
- add an overlay to items if you are not logged in
- add coockie consense
- add footer with terms & condition
- favicon
- limit homepage items
- on access if no object has been inserted, add a text with instructions
- handle facebook auth exceptions

## TODO
- Show facebook javascript sdk popup to invite friends
- 'book' functionality

## WARNING
- Always install sudo apt-get install php7.2-curl otherwise facebook graph-sdk try to use guzzle 5
but laravel takes the 6 and breaks
- Simply install if sudo apt-get install php7.2-mbstring
