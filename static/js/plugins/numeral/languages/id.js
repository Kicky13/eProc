/*! 
 * numeral.js language configuration
 * language : indonesian
 * author : Royyan Bachtiar
 */
(function () {
    var language = {
        delimiters: {
            thousands: '.',
            decimal: ','
        },
        abbreviations: {
            thousand: 'k',
            million: 'jt',
            billion: 'm',
            trillion: 't'
        },
        ordinal : function (number) {
            return number;
        },
        currency: {
            symbol: 'IDR '
        }
    };

    // Node
    if (typeof module !== 'undefined' && module.exports) {
        module.exports = language;
    }
    // Browser
    if (typeof window !== 'undefined' && this.numeral && this.numeral.language) {
        this.numeral.language('id', language);
    }
}());
