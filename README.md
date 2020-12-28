
# Dinosaur API
This is an API to get information about dinosaurs
# Data Source
The data is sourced from Wikidata, the SPARQL query is as follows:

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
