
# Dinosaur API
This is an API to get information about dinosaurs. The API was created using the Laravel framework.

## Getting Started
If you would like to contribute you can get started with this project by following these instructions:  
1. Clone the repo
```sh
git clone https://github.com/GeorgeBetts/DinosaurAPI.git
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
