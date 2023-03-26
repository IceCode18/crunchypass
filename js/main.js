const ChallengeModule = (() => {
    const toggleChallenge = document.getElementById("challenge-toggle");
    const challengeCreate = document.getElementById("challenge-create");
    const challengeQuestion = document.getElementById("challenge-question");
    const challengeAnswer = document.getElementById("challenge-answer");
  
    const hideCustomChallengeInput = () => {
      challengeAnswer.removeAttribute("pattern");
      challengeQuestion.removeAttribute("required");
      challengeAnswer.removeAttribute("required");
      challengeCreate.style.opacity = "0";
      setTimeout(() => {
        challengeCreate.style.display = "none";
      }, 300);
    };
  
    const showCustomChallengeInput = () => {
      challengeCreate.style.display = "block";
      challengeCreate.style.opacity = "1";
      challengeAnswer.setAttribute("pattern", "\\S+");
      challengeQuestion.setAttribute("required", true);
      challengeAnswer.setAttribute("required", true);
    };
  
    const toggle = () => {
      if (toggleChallenge.checked) {
        showCustomChallengeInput();
      } else {
        hideCustomChallengeInput();
      }
    };
  
    const init = () => {
      if (challengeQuestion !== null && challengeAnswer !== null) {
        hideCustomChallengeInput();
      }
  
      if (toggleChallenge !== null) {
        toggleChallenge.addEventListener("click", toggle);
      }
    };
  
    return {
      init,
    };
  })();
  
  ChallengeModule.init();
  
  
  
  
  
  
  // Function to toggle the navigation menu
  function navToggle() {
    var x = document.getElementById("myTopnav");
    var container = document.getElementById("nav-container");
    if (x !== null && container !== null) {
      if (x.className === "topnav") {
        container.className += " responsive";
        x.className += " responsive";
      } else {
        x.className = "topnav";
        container.className = "nav-container";
      }
    }
  }
  
  // Module to handle coupon cards
  var couponModule = (function () {
    // Private variables and methods
    function handleCardClick(e) {
        // Prevent the default link behavior
        e.preventDefault();
  
        // Extract the ID from the card's ID attribute
        var id = this.id;
  
        // Redirect the user to the coupon details page with the ID parameter in the URL
        window.location.href = 'challenge.php?id=' + id;
    }
  
    // Public variables and methods
    return {
        init: function() {
            // Get all the coupon cards and add a click event listener to each one
            var cards = document.querySelectorAll('.card');
            for (var i = 0; i < cards.length; i++) {
                cards[i].addEventListener('click', handleCardClick);
            }
        }
    };
  })();
  
  // Call the init method to initialize the couponModule
  couponModule.init();
  
  // Function to validate the feedback form
  function validateCouponSubmitForm() {
    const toggleChallenge = document.getElementById("challenge-toggle");
      if(toggleChallenge.checked){
          var question = document.getElementById("challenge-question");
          if (question !== null) {
              var questionValue = question.value;
              if (!questionValue.trim()) {
                  question.value = "";
                  question.placeholder = "Challenge must not be empty or contain only whitespaces!";
                  return false;
              }
          }
          return true;
      }
    }
  
  // Function to validate the feedback form
  function validateFeedbackForm() {
    var comment = document.getElementById("comment");
    if (comment !== null) {
      var commentValue = comment.value;
      if (!commentValue.trim()) {
        alert("Comment must not be empty or contain only whitespaces!");
        return false;
      }
    }
    return true;
  }
  