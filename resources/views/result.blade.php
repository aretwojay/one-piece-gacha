<h1>Résultat du tirage</h1>
<p>Tu as obtenu : <strong>{{ $character->nom }}</strong></p>
<p>Prime : {{ $character->prime }} Berrys</p>
<img src="{{ $character->image_url }}" alt="{{ $character->nom }}" style="width: 200px;">

<br><br>
<a href="/tirage">Rejouer !</a>