//menu

document.getElementById("menu_toggle").addEventListener("click",(event)=>{
    if( document.getElementById("menu_content_container").style.display == "none"){
         document.getElementById("menu_content_container").style.display ="flex"
         return
    }
    document.getElementById("menu_content_container").style.display ="none"
})

//scrolling text
const filmQuotes = [
    { quote: "Kino to kwestia tego, co jest w kadrze i co jest poza nim.", author: "Martin Scorsese" },
    { quote: "Film jest – a przynajmniej powinien być – bardziej jak muzyka niż jak fikcja. Powinien być progresją nastrojów i uczuć.", author: "Stanley Kubrick" },
    { quote: "Filmy poruszają nasze serca, budzą naszą wyobraźnię i zmieniają sposób, w jaki patrzymy na świat.", author: "Martin Scorsese" },
    { quote: "Kino powinno sprawić, że zapomnisz, iż siedzisz w kinie.", author: "Roman Polański" },
    { quote: "Długość filmu powinna być ściśle związana z wytrzymałością ludzkiego pęcherza.", author: "Alfred Hitchcock" },
    { quote: "Kino to najpiękniejsze oszustwo na świecie.", author: "Jean-Luc Godard" },
    { quote: "Aby stworzyć świetny film, potrzebujesz trzech rzeczy – scenariusza, scenariusza i scenariusza.", author: "Alfred Hitchcock" },
    { quote: "Film nigdy nie jest naprawdę dobry, jeśli kamera nie jest okiem poety.", author: "Orson Welles" },
    { quote: "Całe życie jest jak oglądanie filmu.", author: "Terry Gilliam" },
    { quote: "Każdy wielki film powinien wydawać się nowy za każdym razem, gdy go oglądasz.", author: "Roger Ebert" },
    { quote: "Dramat to życie z wyciętymi nudnymi fragmentami.", author: "Alfred Hitchcock" },
    { quote: "Najuczciwszą formą tworzenia filmów jest robienie ich dla siebie samego.", author: "Peter Jackson" },
    { quote: "Tworzenie filmów to szansa, aby przeżyć wiele żyć.", author: "Robert Altman" },
    { quote: "Historia powinna mieć początek, środek i koniec, ale niekoniecznie w tej kolejności.", author: "Jean-Luc Godard" },
    { quote: "Jeśli można to napisać lub pomyśleć, można to sfilmować.", author: "Stanley Kubrick" },
    { quote: "Najlepszym sposobem na naukę robienia filmów jest ich tworzenie.", author: "Stanley Kubrick" },
    { quote: "W filmach fabularnych reżyser jest Bogiem; w dokumentach to Bóg jest reżyserem.", author: "Alfred Hitchcock" },
    { quote: "Najlepsze filmy powstają przez brak pieniędzy.", author: "Lars von Trier" },
    { quote: "Kino zastępuje naszemu spojrzeniu świat bardziej harmonijny z naszymi pragnieniami.", author: "André Bazin" },
    { quote: "Jeśli chcesz opowiadać historie, bądź pisarzem, nie reżyserem filmowym.", author: "Luc Besson" }
];

let rand_quote = filmQuotes[Math.floor(Math.random()*filmQuotes.length)]
document.querySelector("#scrolling_text>div").innerHTML = rand_quote.quote + "<br> ~"+rand_quote.author

document.querySelector("#scrolling_text>div").addEventListener("animationiteration",()=>{
    let rand_quote = filmQuotes[Math.floor(Math.random()*filmQuotes.length)]
    document.querySelector("#scrolling_text>div").innerHTML = rand_quote.quote + "<br> ~"+rand_quote.author
})