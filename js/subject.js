const MAIN = document.querySelector("main");
const LIST = document.createElement("ol");
const lastElement = document.querySelector("#modalBackground");
let isScrolled = false;
let books = [];
let indexNum = 0;
var searchNumber = 0;
let modalReview = false;

loadSearch();

/**
 * Gets the users last saved search value and, if a value exists, uses it to autopopulate the search bar and load the matching content
 * 
 */
function loadSearch() {
  let rawValue = document.querySelector("main h1").innerHTML;
  var searchValue = rawValue.replace( /(<([^>]+)>)/ig, '');
  let searchType = "subject";
  if(searchValue !== "") {

    // SEARCH.value = searchValue;

    let url = `https://www.googleapis.com/books/v1/volumes?q=search+${searchType}:${searchValue}&key=AIzaSyB_PSiIxj2VfyklbxORej0LorymkSYZCCI`;
    createRequest(url, searchValue, searchType, searchSuccess, searchError, 0);
  }
}

/**
 * Creates a fetch request using a provided url, then submits it for error handling, and passes the returned information to appropriate functions
 *
 * @param {string} url - the url to be used in the fetch request
 * @param {string} searchValue - the search value input by the user
 * @param {function} onSuccess - the function to be called if the fetch request is successful
 * @param {function} onError - the function to be called if the fetch request encounters an error
 * @param {numeric} indexNum - the index number used in the request
 *
 */
function createRequest(url, searchValue, searchType, onSuccess, onError, indexNum) {
  fetch(url)
    .then(responseFromServer => handleErrors(responseFromServer))
    .then(goodData => onSuccess(goodData, searchValue, searchType, indexNum))
    .catch(thereWasAnError => onError(thereWasAnError, searchValue));
}

/**
 * Checks to see if a fetch request was successful or not and returns the appropriate information
 *
 * @param {object} response - the fetch request to be checked
 *
 */
function handleErrors(response) {
  if(!response.ok) {
    throw(response.status + ': ' + response.statusText);
  }
  return response.json();
}

function searchSuccess(parsedData, searchValue, searchType, index){
  let total = parsedData.totalItems;
  var error = false;
  
  MAIN.append(LIST);
  
  if(total > 0) {
    if(parsedData.items != undefined) {
      for(i = 0; i < parsedData.items.length; i++) {
        books.push(parsedData.items[i]);
        
        const TITLE = document.createElement("p");
        const DETAILS = document.createElement("p");
        const detailsLink = document.createElement("a");
        const IMAGE = document.createElement("img");
        const listItem = document.createElement("li");

        TITLE.textContent = parsedData.items[i].volumeInfo.title;

        DETAILS.append(detailsLink);
        detailsLink.innerHTML = "About this book &#xbb;";
        detailsLink.setAttribute("href", "#");
        detailsLink.setAttribute("data-id", parsedData.items[i].volumeInfo.industryIdentifiers[0].identifier);
        
        let id = i;
        
        detailsLink.addEventListener("click", function(e) {
          e.preventDefault();
          modalUrl(parsedData.items[id].volumeInfo.industryIdentifiers[0].identifier);
        });
        
        if(parsedData.items[i].volumeInfo.imageLinks != undefined) {
          IMAGE.setAttribute("src", parsedData.items[i].volumeInfo.imageLinks.smallThumbnail);
          IMAGE.setAttribute("alt", `${parsedData.items[i].volumeInfo.title} book cover`);
        } else {
          IMAGE.setAttribute("src", "../media/images/image-not-found.png");
          IMAGE.setAttribute("alt", `Image replacement for missing book cover`);
          IMAGE.className = "replacement-image";
        }

        listItem.append(TITLE);
        listItem.append(DETAILS);
        listItem.append(IMAGE);

        LIST.append(listItem);
      }
    }
  }
    
  const infiniteScroll = () => {
    if (window.scrollY > (document.body.offsetHeight - 1200) && !isScrolled) {
      isScrolled = true;
      indexNum++;
      let url = `https://www.googleapis.com/books/v1/volumes?q=search+${localStorage.getItem("searchType")}:${searchValue}&startIndex=${indexNum * 10}&key=AIzaSyB_PSiIxj2VfyklbxORej0LorymkSYZCCI`;
      createRequest(url, searchValue, searchType, searchSuccess, searchError, indexNum);

      setTimeout(function() {
        isScrolled = false;
      }, 1000);
    } // end if
  }

  if(indexNum == 0 && error == false) {
    saveSearch(searchValue, searchType);
    window.addEventListener('scroll', infiniteScroll);
  }
}

/**
 * Saves the value the user searched for in local storage
 * 
 * @param {string} searchText - the search value input by the user
 *
 */
function saveSearch(searchValue, searchType) {
  localStorage.setItem("searchValue", searchValue);
  localStorage.setItem("searchType", searchType);
}

/**
 * Displays an error message if the request fails and console logs the error for developers
 * 
 * @param {string} response - the error message generated by the handleErrors function
 *
 */
function searchError(response){
  console.log("Error!"); 
  console.log(response);
}

function modalUrl(id) {
  let url = `https://www.googleapis.com/books/v1/volumes?q=search+isbn:${id}&key=AIzaSyB_PSiIxj2VfyklbxORej0LorymkSYZCCI`;
  createRequest(url, id, "", modalSuccess, modalFail, 0);
}

function getISBN10(isbn){
  return isbn.type === "ISBN_10"; 
}

function modalSuccess(parsedData, id) {
  const modalBack = document.querySelector("#modalBackground");
  const modalClose = document.querySelector("#close");
  const modalImg = document.querySelector("#modalBox img");
  const TITLE = document.querySelector("#modalBox div:first-of-type p");
  const AUTHOR = document.querySelector("#modalBox div:nth-of-type(2) p");
  const PUBLISHER = document.querySelector("#modalBox div:nth-of-type(3) p");
  const YEAR = document.querySelector("#modalBox div:nth-of-type(4) p");
  const EXCERPT = document.querySelector("#modalBox div:nth-of-type(5) p");
  const REVIEWS = document.querySelector("#reviewViewing");
  const WRITING = document.querySelector("#reviewWriting");

  if(parsedData.items != undefined) {
  
    REVIEWS.style.display = "block";
    WRITING.style.display = 'none';
    
    if(document.querySelector("#review-button") != null) {
      bookISBN = parsedData.items[0].volumeInfo.industryIdentifiers.find(getISBN10);
  
      bookshelfForm = document.querySelector("#modalBox > form");
      bookshelfISBN = document.querySelector("#modalBox form input:first-of-type");
      bookshelfSubmit = document.querySelector("#modalBox form input:nth-of-type(2)");
      
      bookshelfISBN.value = bookISBN.identifier;
      
      const writeButton = document.querySelector("#review-button");
      const reviewHeading = document.querySelector("#reviewWriting > h3");
      const reviewISBN = document.querySelector("#review_isbn");
      let book = parsedData.items[0].volumeInfo.title;
  
      // writeButton.before(bookshelfForm);
      
      reviewHeading.className = "bold";
      reviewHeading.textContent = `Reviewing ${book}`;
      reviewISBN.value = parsedData.items[0].volumeInfo.industryIdentifiers[0].identifier;
      
      if(modalReview == false) {
        writeButton.addEventListener('click', modalReviewing);
      }
    }
    
    fetch(`review-fetch.php?isbn=${parsedData.items[0].volumeInfo.industryIdentifiers[0].identifier}`)
      .then(responseFromServer => responseFromServer.text())
      .then(goodData => document.getElementById("reviews").innerHTML = goodData)
      .catch(thereWasAnError => console.log(thereWasAnError));
    
    const reviewBook = document.querySelector("#reviewViewing h3");
    
    if(parsedData.items[0].volumeInfo.title != undefined) {
      TITLE.textContent = parsedData.items[0].volumeInfo.title;
    }
    if(parsedData.items[0].volumeInfo.authors != undefined) {
      for(i = 0; i < parsedData.items[0].volumeInfo.authors.length; i++) {
        AUTHOR.textContent = parsedData.items[0].volumeInfo.authors[0];
        if(i > 0) {
          var br = document.createElement("br");
          AUTHOR.appendChild(br);
          var writer = document.createElement("p");
          writer.textContent = parsedData.items[0].volumeInfo.authors[i];
          AUTHOR.appendChild(writer);
        }
      }
    }
    if(parsedData.items[0].volumeInfo.publisher != undefined) {
      PUBLISHER.textContent = parsedData.items[0].volumeInfo.publisher;
    }
    if(parsedData.items[0].volumeInfo.publishedDate != undefined) {
      YEAR.textContent = parsedData.items[0].volumeInfo.publishedDate.substring(0, 4);
    }
    if(parsedData.items[0].volumeInfo.description != undefined) {
      EXCERPT.textContent = parsedData.items[0].volumeInfo.description;
    }
    
    reviewBook.textContent = `Reviews for ${parsedData.items[0].volumeInfo.title}`;
    
    modalBack.style.display = "block";
    
    if(parsedData.items[0].volumeInfo.imageLinks != undefined) {
      modalImg.setAttribute("src", parsedData.items[0].volumeInfo.imageLinks.smallThumbnail);
      modalImg.setAttribute("alt", `${parsedData.items[0].volumeInfo.title} book cover`);
    } else {
      modalImg.setAttribute("src", "../media/images/image-not-found.png");
      modalImg.setAttribute("alt", `Image replacement for missing book cover`);
    }
  } else {
    const DETAILS = document.querySelectorAll("ol a");
    for (i = 0; i < DETAILS.length; i++) {
      var detailID = DETAILS[i].getAttribute("data-id");
      if (id == detailID) {
        DETAILS[i].textContent = "Sorry, no information on this book is available.";
        DETAILS[i].className = "error";
      }
    }
  }
  
  modalClose.addEventListener('click', function(){
    modalBackground.style.display = 'none';
  });
  
  modalBack.addEventListener('click', function (e) {
    if(e.target.matches('#modalBackground')) {
      modalBack.style.display = 'none';
    }
  });
}

function modalReviewing(e) {
  e.preventDefault();
  
  const REVIEWS = document.querySelector("#reviewViewing");
  REVIEWS.style.display = 'none';

  const WRITING = document.querySelector("#reviewWriting");
  WRITING.style.display = 'block';
  modalReview = true;
}

function modalFail(response, id) {
  const DETAILS = document.querySelectorAll("ol a");
  for (i = 0; i < DETAILS.length; i++) {
    var detailID = DETAILS[i].getAttribute("data-id");
    if (id == detailID) {
      DETAILS[i].textContent = "Sorry, an error has occurred.";
      DETAILS[i].className = "error";
    }
  }
  console.log(response);
}

function showCustomer(str) {
  var xhttp;
  if (str == "") {
    document.getElementById("txtHint").innerHTML = "";
    return;
  }
  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
    document.getElementById("txtHint").innerHTML = this.responseText;
    }
  };
  xhttp.open("GET", "getcustomer.php?q="+str, true);
  xhttp.send();
}