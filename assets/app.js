$(document).one('search:fullscreen', function() {
    $('section.search').addClass('smaller');
    $('.content').addClass('active');
});

$('#algolia-search').keyup(function() {
    if ($(this).val() !== '') {
        setTimeout(function() {
            $(document).trigger('search:fullscreen');
        }, 500);
    }
});

function createThumbnail(img) {
    var parent = img.parentNode;
    var imgSrc = img.src;

    img.parentNode.removeChild(img);

    // We use the seedrandom library to get a seeded randomizer. This helps
    // create a feel of consistency between navigation and refreshes so that
    // each thumbnail keeps its original colors when we dynamically it.
    var randomizer = new Math.seedrandom(imgSrc);

    // The thumbnail should never deviate more than a value of 50 in either
    // direction from any singly RGB channel. We'll use a starting point of:
    // 125, 125, 125 and only modify a single channel at a time.
    var rgba = [125, 125, 125, 0.5];
    var randomChannel = Math.ceil(randomizer() * 3);
    var randomOffset = Math.ceil((randomizer() * 200) - 100);

    rgba[randomChannel - 1] += randomOffset;

    parent.innerHTML += '<div class="placeholder-logo" style="background-color: rgba(' + rgba.join(',') + ')">' + parent.dataset.initials + '</div>';

    return true;
}

var search = instantsearch({
    appId: 'WMZDP1H9DH',
    apiKey: 'a3ef38808b09b028ab89584fc1eae448',
    indexName: 'apps'
});

search.addWidget(
    instantsearch.widgets.searchBox({
        container: '#algolia-search'
    })
);

search.addWidget(
  instantsearch.widgets.hits({
    container: '#hits-container',
    hitsPerPage: 60,
    templates: {
        item: function(data) {
            // Extract the first 3 alphanumeric characters from the name. This
            // will come in handy later when we want to dynamically generate
            // thumbnails for invalid/missing images.
            data.initials = data.name.replace(/[^0-9a-z]/gi, '').substring(0, 3);

            var template = [
                '<div class="app-container">',
                    '<a href="' + data.link + '" class="app-logo" data-initials="' + data.initials + '">',
                        '<img src="' + data.image + '" onerror="createThumbnail(this);">',
                    '</a>',
                    '<div class="app-details">',
                        '<div class="app-name">' + data.name + '</div>',
                        '<div class="app-category">' + data.category + '</div>',
                    '</div>',
                '</div>'
            ];

            return template.join('');
        }
    }
  })
);

search.addWidget(
    instantsearch.widgets.refinementList({
        container: '#facets-container',
        attributeName: 'category'
    })
);

search.start();
