/*
Original code for NodeJS from 
https://github.com/web-mech/badwords
Rewritten for mostly VanillaJS & jQuery
*/
var baseList = {};
var localList;
$.getJSON('$2y$12$ZdrjTKpRo0UnQ6wyYBYZmOo5dW5ZZQZJTTfd4M9ulvyWt57J3fLMi.json', function(data) {         
    localList = data['words'];
    console.log("word bank loaded");
});
var Filter = (function() {
  /**
   * Filter constructor.
   * @constructor
   * @param {object} options - Filter instance options
   * @param {boolean} options.emptyList - Instantiate filter with no blacklist
   * @param {array} options.list - Instantiate filter with custom list
   * @param {string} options.placeHolder - Character used to replace profane words.
   * @param {string} options.regex - Regular expression used to sanitize words before comparing them to blacklist.
   * @param {string} options.replaceRegex - Regular expression used to replace profane words with placeHolder.
   */
  function Filter(options) {
    options = options || {};
    this.list = options.emptyList && [] || Array.prototype.concat.apply(localList, [baseList, options.list || []]);
    this.exclude = options.exclude || [];
    this.placeHolder = options.placeHolder || '*';
    this.regex = options.regex || /[^a-zA-z0-9|\$|\@]|\^/g;
    this.replaceRegex = options.replaceRegex || /\w/g;
  }

  /*
  Escapes those rid of those pesky *$()/\ in reg expressions
  Special Thanks to StackOverflow user Mathias Bynens for answering
  https://stackoverflow.com/questions/3115150/how-to-escape-regular-expression-special-characters-using-javascript?utm_medium=organic&utm_source=google_rich_qa&utm_campaign=google_rich_qa
  */
  function escapeRegExp(text) {
      return text.replace(/[-[\]{}()*+?.,\\/^$|#\s]/g, '\\$&');
  }

  /**
   * Determine if a string contains profane language.
   * @param {string} string - String to evaluate for profanity.
   */
  Filter.prototype.isProfane = function testProfane(string) {
    for (var i = this.list.length - 2; i >= 0; i--) {
      var badwordReference = this.list[i];
      badwordReference = escapeRegExp(badwordReference);
      var regex = new RegExp(badwordReference, "gi");
      // bad word found, return true!
      if (regex.test(string))
        return true;
    }
    // no bad word found
    return false;
  };

  return Filter;
})();
