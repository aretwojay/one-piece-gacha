import scrapy
from scrapy.http import Response
import re

class OnepieceSpider(scrapy.Spider):
    name = "onepiece"
    allowed_domains = ["onepiece.fandom.com"]
    start_urls = ["https://onepiece.fandom.com/wiki/List_of_Canon_Characters#Individuals"] 
    
    # Paramètres pour éviter d'être bloqué (anti-ban)
    # custom_settings = {
    #     'DOWNLOAD_DELAY': 1, # Attendre 1 seconde entre chaque requête
    #     'RANDOMIZE_DOWNLOAD_DELAY': True, # Aléatoire: entre 1s et 3s
    #     'AUTOTHROTTLE_ENABLED': True,
    #     'AUTOTHROTTLE_START_DELAY': 1,
    #     'AUTOTHROTTLE_MAX_DELAY': 10,
    #     'AUTOTHROTTLE_TARGET_CONCURRENCY': 1.0,
    # }

    HEADERS = {
        "User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:98.0) Gecko/20100101 Firefox/98.0",
        "Accept": "text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8",
        "Accept-Language": "en-US,en;q=0.5",
        "Accept-Encoding": "gzip, deflate",
        "Connection": "keep-alive",
        "Upgrade-Insecure-Requests": "1",
        "Sec-Fetch-Dest": "document",
        "Sec-Fetch-Mode": "navigate",
        "Sec-Fetch-Site": "none",
        "Sec-Fetch-User": "?1",
        "Cache-Control": "max-age=0"
    }

    def parse(self, response: Response):
        all_links = response.css("td:nth-child(2) a::attr(href)").getall()
        for link in all_links:
            yield response.follow(link, callback=self.parse_character, headers=self.HEADERS)
        

    def format_wiki_list(self, arr: list[str]) -> list[str]:
        # 1. Join everything into a single string separated by spaces
        text = ' '.join(arr)
        
        # 2. Remove Wiki citations like "[ 2 ]" or "[3]" using Regex
        text = re.sub(r'\[\s*\d+\s*\]', '', text)
        
        # 3. Split by semicolon, strip spaces, and filter out empty strings
        # A list comprehension handles the map() and filter() in one step
        return [item.strip() for item in text.split(';') if item.strip()]
    
    def parse_character(self, response: Response):
        image = response.css("img.pi-image-thumbnail::attr(src)").get()
        english_name = response.css("div[data-source='ename'] div::text").get()
        romaji_name = response.css("div[data-source='rname'] div i::text").get()
        japanese_name = response.css("div[data-source='jname'] div *::text").getall()
        japanese_name = "".join([name.strip() for name in japanese_name if not name.startswith("(")])

        debut_appearance = response.css("div[data-source='first'] div *::text").getall()
        debut_appearance = [appearance.strip() for appearance in debut_appearance if "Episode" in appearance or "Chapter" in appearance]

        affiliations = response.css("div[data-source='affiliation'] div *::text").getall()
        affiliations = self.format_wiki_list(affiliations)

        occupations = response.css("div[data-source='occupation'] div *::text").getall()
        occupations = self.format_wiki_list(occupations)

        origin = response.css("div[data-source='origin'] div *::text").get()

        status = response.css("div[data-source='status'] div *::text").get()
        age = response.css("div[data-source='age'] div *::text").getall()
        age = self.format_wiki_list(age)[-1] if age else None
        
        height = response.css("div[data-source='height'] div *::text").getall()
        height = self.format_wiki_list(height)[-1] if height else None

        blood_type = response.css("div[data-source='blood type'] div *::text").get()

        birthday = response.css("div[data-source='birth'] div *::text").get()

        devil_fruit = response.css("div[data-source='dfname'] div *::text").get()

        bounty = response.css("div[data-source='bounty'] div *::text").get()

        yield {
            "image_url": image,
            "english_name": english_name,
            "romaji_name": romaji_name,
            "japanese_name": japanese_name,
            "debut_appearance": debut_appearance,
            "affiliations": affiliations,
            "occupations": occupations,
            "origin": origin,
            "status": status,   
            "age": age,
            "height": height,
            "blood_type": blood_type,
            "birthday": birthday,
            "devil_fruit": devil_fruit,
            "bounty": bounty
        }
        pass
