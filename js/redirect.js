const BODY = document.querySelector("body");
const SEARCH = document.querySelector("#search");
const SUBMIT = document.querySelector("#submit-search");
const PARAM = document.querySelector("#search-type");

prepareForSearch();

function prepareForSearch() {
  const SUBMIT = document.querySelector("#submit-search"); 
  SUBMIT.addEventListener("click", function(e){
    e.preventDefault();
    var searchValue = SEARCH.value;
    localStorage.setItem("searchValue", searchValue);
    var searchType = PARAM.value;
    console.log(searchType);
    localStorage.setItem("searchType", searchType);
    window.location.href = "/WEB289/public/search.php";
  });
}