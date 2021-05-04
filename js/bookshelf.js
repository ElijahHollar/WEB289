const LIST = document.querySelector("ol");
let modalReview = false;

fetch(`bookshelf-fetch.php`)
    .then(responseFromServer => responseFromServer.text())
    .then(goodData => bookshelfDisplay(goodData))

function bookshelfDisplay(bookshelfData) {
  document.querySelector("#isbnStorage").innerHTML = bookshelfData;

  const ISBNS = document.querySelectorAll("#isbnStorage p");

  for (i = 0; i < ISBNS.length; i++) {
    let id = ISBNS[i].textContent;
    let url = `https://www.googleapis.com/books/v1/volumes?q=search+isbn:${id}&key=AIzaSyB_PSiIxj2VfyklbxORej0LorymkSYZCCI`;
    createRequest(url, id, "", booksSuccess, booksError, 0);
  }
}

function createRequest(url, searchValue, searchType, onSuccess, onError, indexNum) {
  fetch(url)
    .then(responseFromServer => handleErrors(responseFromServer))
    .then(goodData => onSuccess(goodData, searchValue, searchType, indexNum))
    .catch(thereWasAnError => onError(thereWasAnError, searchValue));
}

function booksSuccess(parsedData) {
      const TITLE = document.createElement("p");
      const DETAILS = document.createElement("p");
      const detailsLink = document.createElement("a");
      const IMAGE = document.createElement("img");
      const listItem = document.createElement("li");

      TITLE.textContent = parsedData.items[0].volumeInfo.title;

      DETAILS.append(detailsLink);
      detailsLink.innerHTML = "About this book &#xbb;";
      detailsLink.setAttribute("href", "#");
      detailsLink.setAttribute("data-id", parsedData.items[0].volumeInfo.industryIdentifiers[0].identifier);
      
      detailsLink.addEventListener("click", function(e) {
        e.preventDefault();
        modalUrl(parsedData.items[0].volumeInfo.industryIdentifiers[0].identifier);
      });
      
      if(parsedData.items[0].volumeInfo.imageLinks != undefined) {
        IMAGE.setAttribute("src", parsedData.items[0].volumeInfo.imageLinks.smallThumbnail);
        IMAGE.setAttribute("alt", `${parsedData.items[0].volumeInfo.title} book cover`);
      } else {
        IMAGE.setAttribute("src", "../media/images/image-not-found.png");
        IMAGE.setAttribute("alt", `Image replacement for missing book cover`);
      }

      listItem.append(TITLE);
      listItem.append(DETAILS);
      listItem.append(IMAGE);

      LIST.append(listItem);
}

function booksError(response){
  console.log("Error!");
  console.log(response);
}

function modalUrl(id) {
  let url = `https://www.googleapis.com/books/v1/volumes?q=search+isbn:${id}&key=AIzaSyB_PSiIxj2VfyklbxORej0LorymkSYZCCI`;
  createRequest(url, id, "", modalSuccess, modalFail, 0);
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
      const writeButton = document.querySelector("#review-button");
      const reviewHeading = document.querySelector("#reviewWriting > h3");
      const reviewISBN = document.querySelector("#review_isbn");
      let book = parsedData.items[0].volumeInfo.title;

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

function handleErrors(response) {
  if(!response.ok) {
    throw(response.status + ': ' + response.statusText);
  }
  return response.json();
}
