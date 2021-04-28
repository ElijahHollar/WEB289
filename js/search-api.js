const BODY = document.querySelector("body");
const MAIN = document.querySelector("main");
const SEARCH = document.querySelector("#search");
const LIST = document.createElement("ol");
const PARAM = document.querySelector("#search-type");
const lastElement = document.querySelector("#modalBackground");
let isScrolled = false;
let books = [];
let indexNum = 0;
var searchError = false;
var searchNumber = 0;

loadSearch();
submitSearchTerm();

console.log(MAIN.lastElementChild);

/**
 * Builds a URL string from the user's search term/phrase then passes that url to a function that creates the request
 *
 */
function submitSearchTerm() {
  const SUBMIT = document.querySelector("#submit-search"); 
  SUBMIT.addEventListener("click", function(e){
    e.preventDefault();
    console.log("Click!");
    indexNum = 0;
    var searchValue = SEARCH.value;
    var paramValue = PARAM.value;
    var searchType = "";
    if(paramValue == "title") {
      searchType = "intitle";
    } else if(paramValue == "category") {
      searchType = "subject";
    } else if(paramValue == "author") {
      searchType = "inauthor";
    } else if(paramValue == "publisher") {
      searchType = "inpublisher";
    } else if(paramValue == "isbn") {
      searchType = "isbn";
    }
    console.log(searchType);
    if(searchValue !== "") {
      searchError = false;
      let url = `https://www.googleapis.com/books/v1/volumes?q=search+${searchType}:${searchValue}&startIndex=${indexNum}&key=AIzaSyB_PSiIxj2VfyklbxORej0LorymkSYZCCI`;
      createRequest(url, searchValue, searchType, searchSuccess, searchError, 0);
    } else if(searchError == false) {
      if(MAIN.lastElementChild != lastElement) {
        movies = [];
      
        document.querySelector("h2:last-of-type").style.display = "none";
      
        LIST.textContent = "";
      }
      const HEADER = document.createElement("h2");
      HEADER.innerHTML = `Please enter a search term.`;
      MAIN.append(HEADER);
      searchError = true;
    }
  });
}

/**
 * Gets the users last saved search value and, if a value exists, uses it to autopopulate the search bar and load the matching content
 * 
 */
function loadSearch() {
  let searchValue = localStorage.getItem("searchValue");
  let searchType = localStorage.getItem("searchType");
  if(searchValue !== "") {
    console.log(searchValue);
    SEARCH.value = searchValue;
    if(localStorage.getItem("searchType") == "title") {
      searchType = "intitle";
    } else if(localStorage.getItem("searchType") == "category") {
      searchType = "subject";
    } else if(localStorage.getItem("searchType") == "author") {
      searchType = "inauthor";
    } else if(localStorage.getItem("searchType") == "publisher") {
      searchType = "inpublisher";
    } else if(localStorage.getItem("searchType") == "isbn") {
      searchType = "isbn";
    }
    console.log(searchType);
    let url = `https://www.googleapis.com/books/v1/volumes?q=search+${searchType}:${searchValue}&startIndex=${indexNum}&key=AIzaSyB_PSiIxj2VfyklbxORej0LorymkSYZCCI`;
    createRequest(url, searchValue, searchType, searchSuccess, searchError, 0);
  } else if(searchError == false) {
    if(MAIN.lastElementChild != lastElement) {
      movies = [];
    
      document.querySelector("h2:last-of-type").style.display = "none";
    
      LIST.textContent = "";
    }
    const HEADER = document.createElement("h2");
    HEADER.innerHTML = `Please enter a search term.`;
    MAIN.append(HEADER);
    searchError = true;
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
  const HEADER = document.createElement("h2");
  let total = parsedData.totalItems;
  var error = false;

  searchNumber++;

  // lastElement.innerHTML = `Total searchs: ${searchNumber}`;

  if(total > 0) {
    HEADER.innerHTML = `Search results for <i>${searchValue}</i>:`;
  } else if (indexNum == 0) {
    error = true;
    LIST.textContent = "";
    HEADER.innerHTML = `Sorry. No movies found with <i>${searchValue}</i>`;
  }
  
  if(MAIN.lastElementChild != lastElement && indexNum == 0) {
    books = [];

    document.querySelector("h2:last-of-type").style.display = "none";
     
    MAIN.append(HEADER);

    if(total > 0) {
      LIST.textContent = "";
      MAIN.append(LIST);
    }
  } else if(indexNum == 0) {
    MAIN.append(HEADER);
    if(total > 0) {
      MAIN.append(LIST);
    }
  }
  
  if(total > 0) {  
    for(i = 0; i < parsedData.items.length; i++) {
      books.push(parsedData.items[i]);

      // console.log(parsedData.items[i]);
      // console.log(parsedData.items[i].volumeInfo.industryIdentifiers[0].identifier);
      
      const TITLE = document.createElement("p");
      const YEAR = document.createElement("p");
      const DETAILS = document.createElement("p");
      const detailsLink = document.createElement("a");
      const IMAGE = document.createElement("img");
      const listItem = document.createElement("li");

      TITLE.textContent = parsedData.items[i].volumeInfo.title;
      // TITLE.className = "title";
      YEAR.textContent = parsedData.items[i].volumeInfo.publishedDate;
      // YEAR.className = "year";
      DETAILS.append(detailsLink);
      // DETAILS.className = "details";
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
        IMAGE.setAttribute("src", "../media/images/noposter.gif");
        IMAGE.setAttribute("alt", `Image replacement for missing book cover`);
      }


      listItem.append(TITLE);
      listItem.append(YEAR);
      listItem.append(DETAILS);
      listItem.append(IMAGE);

      LIST.append(listItem);
    }
  }
    
  const infiniteScroll = () => {
    if (window.scrollY > (document.body.offsetHeight - 1200) && !isScrolled) {
      isScrolled = true;
      indexNum++;
      let url = `https://www.googleapis.com/books/v1/volumes?q=search+${localStorage.getItem("searchType")}:${SEARCH.value}&startIndex=${indexNum * 10}&key=AIzaSyB_PSiIxj2VfyklbxORej0LorymkSYZCCI`;
      createRequest(url, searchValue, searchType, searchSuccess, searchError, indexNum);
      console.log(url);

      setTimeout(function() {
        isScrolled = false;
      }, 1000);
    } // end if
  }

  if(indexNum == 0 && error == false) {
    saveSearch(searchValue, searchType);
    window.addEventListener('scroll', infiniteScroll);
    // if(window.innerHeight >= document.body.offsetHeight) {
    //   let url = `https://www.googleapis.com/books/v1/volumes?q=search+intitle:${searchValue}&startIndex=${indexNum}&key=AIzaSyB_PSiIxj2VfyklbxORej0LorymkSYZCCI`;
    //   createRequest(url, searchValue, searchSuccess, searchError, indexNum);
	  // }
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

function modalSuccess(parsedData) {
  const modalBack = document.querySelector("#modalBackground");
  const modalBox = document.querySelector("#modalBox");
  const modalClose = document.querySelector("#close");
  const modalImg = document.querySelector("#modalBox img");
  const TITLE = document.querySelector("#modalBox div:first-of-type p:nth-of-type(2)");
  const AUTHOR = document.querySelector("#modalBox div:nth-of-type(2) p:nth-of-type(2)");
  const PUBLISHER = document.querySelector("#modalBox div:nth-of-type(3) p:nth-of-type(2)");
  const YEAR = document.querySelector("#modalBox div:nth-of-type(4) p:nth-of-type(2)");
  const EXCERPT = document.querySelector("#modalBox div:nth-of-type(5) p:nth-of-type(2)");

  console.log(parsedData);

  TITLE.textContent = parsedData.items[0].volumeInfo.title;
  AUTHOR.textContent = parsedData.items[0].volumeInfo.authors[0];
  PUBLISHER.textContent = parsedData.items[0].volumeInfo.publisher;
  YEAR.textContent = parsedData.items[0].volumeInfo.publishedDate.substring(0, 4);
  EXCERPT.textContent = parsedData.items[0].volumeInfo.description;
  
  modalBack.style.display = "block";
  
  if(parsedData.items[0].volumeInfo.imageLinks != undefined) {
    modalImg.setAttribute("src", parsedData.items[0].volumeInfo.imageLinks.smallThumbnail);
    modalImg.setAttribute("alt", `${parsedData.items[0].volumeInfo.title} book cover`);
  } else {
    modalImg.setAttribute("src", "../media/images/noposter.gif");
    modalImg.setAttribute("alt", `Image replacement for missing book cover`);
  }
  
  modalClose.addEventListener('click', () => modalBackground.style.display = 'none');
  
  modalBack.addEventListener('click', function (e) {
    if(e.target.matches('#modalBackground')) {
      modalBack.style.display = 'none';
    }
  });
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
}