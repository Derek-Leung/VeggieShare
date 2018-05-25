  function createNode(element) {
      return document.createElement(element);
  }

  function append(parent, el) {
    return parent.appendChild(el);
  }

  const ul = document.getElementById('contentArea');
  const url = 'https://randomuser.me/api/?results=10';
  fetch("https://spoonacular-recipe-food-nutrition-v1.p.mashape.com/recipes/random?number=10", {
  method: "get",
  headers: {
    "X-Mashape-Key": "xABpzCAF05mshEWbZi3Ze8CZ291Wp11iF8VjsnY3msthyRMMDK",
	"X-Mashape-Host": "spoonacular-recipe-food-nutrition-v1.p.mashape.com"
  }})
  .then((resp) => resp.json())
  .then(function(data) {
    /**var myJSON = JSON.stringify(data);
	
	const p = document.createElement('p');
	p.textContent = myJSON;
	ul.appendChild(p);
	
	const c = document.createElement('p');
	c.textContent = data.recipes[1].title;
	ul.appendChild(c);**/
	
	for (var i=0; i < data.recipes.length; i++){
	
	const card = document.createElement('div');
      card.setAttribute('class', 'container-fluid');
	  card.setAttribute('id', 'breakfast');

      const h1 = document.createElement('a');
      h1.href = 'www.google.ca';

      const img = document.createElement('img');
      img.setAttribute('src', data.recipes[i].image);
	  img.setAttribute('class', 'img-responsive');
	  
	  const textbox = document.createElement('div');
	  textbox.setAttribute('id', 'breakfastText');
	  textbox.setAttribute('class', 'container-fluid');
	  
	  const h2 = document.createElement('h2');
	  h2.textContent = data.recipes[i].title;

      ul.appendChild(card);
      h1.appendChild(img);
	  card.appendChild(h1);
	  textbox.appendChild(h2);
	  h1.appendChild(textbox);
	}})
  .catch(function(error) {
    console.log(error);
  });