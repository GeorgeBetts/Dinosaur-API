
# Dinosaur API
This is an API to get information about dinosaurs. The API was created using the Laravel framework.

## Getting Started
If you would like to contribute you can get started with this project by following these instructions:
1. Clone the repo
```sh
git clone https://github.com/GeorgeBetts/Dinosaur-API.git
```
2. Copy the ENV file and generate a key
```sh
cp .env.example .env
php artisan key:generate
```
3. Install NPM & Composer packages
```sh
npm install
composer install
```
4. Run database migrations and seeder
```sh
php artisan migrate
php artisan db:seed
```

## Usage
The API follows standard REST resource structure. The resoures available in the API are:
* Dinosaur

To interact with these resources the following endpoints are available:

* GET /resource
* GET /resource/{id}

E.g. to retrieve a list of Dinosaurs
```
http://localhost/api/dinosaurs
```
You can also filter the Dinosaurs resource using the following parameters:  
| Parameter | Type | Description
| --- | --- | --- |
| name | String | Search string to filter by dinosaur name |
| exact_match | Bool | Set to true if you want all String parameters to be an exact match of your search parameter |
| has_image | Bool | Set to true to only return records that have at least one image |
| has_article | Bool | Set to true to only return records that have at least one article |
| has_wikipedia_entry | Bool | Set to true to only return records that have a wikipedia entry |

For example, to retrieve a list of dinosaurs where their name contains 'Stego', that have a wikipedia article and at least one image, you would use the following parameters:
```
http://localhost/api/dinosaurs?name=Stego&has_wikipedia_entry=true&has_image=true
```
To retrieve dinosaurs that match the exact name 'Stegosaurus':
```
http://localhost/api/dinosaurs?name=Stegosaurus&exact_match=true
```
You can also retrieve the Stegosaurus by using it's id:
```
http://localhost/api/dinosaurs/6467
```

## Data Source
The data for this API is taken from WikiData and is imported to a database via the `DinosaurTableSeeder`, this reads in the raw JSON data from Wikidata which is saved in the project at `database/data/wikidata_dinosaurs.json`  
The SPARQL query for Wikidata is as follows:

```SQL
    SELECT ?dinosaur ?dinosaurLabel ?taxon ?image ?startTime ?endTime ?gallery ?sizeComparison ?encyclopedia ?article
    WHERE
    {
      ?dinosaur wdt:P31 wd:Q23038290;
                wdt:P18 ?image.
      MINUS {
        ?dinosaur wdt:p171 wdt:Q171283.  
      }
      OPTIONAL { ?dinosaur wdt:P225 ?taxon. }
      OPTIONAL { ?dinosaur wdt:P580 ?startTime. }
      OPTIONAL { ?dinosaur wdt:P582 ?endTime. }
      OPTIONAL { ?dinosaur wdt:P8512 ?sizeComparison. }
      OPTIONAL { ?dinosaur wdt:P1417 ?encyclopedia. }
      OPTIONAL {
          ?article schema:about ?dinosaur .
          ?article schema:inLanguage "en" .
          ?article schema:isPartOf <https://en.wikipedia.org/> .
      }
      ?dinosaur rdfs:label ?dinosaurLabel filter (lang(?dinosaurLabel) = "en") .
    }
```
