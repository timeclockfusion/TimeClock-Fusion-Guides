/*
 * Generic (global) functions go into this file
 *
 */

/*****
 * This requires the NumberFormat library.
 *
 * Pass in a number string and it returns that number formatted as a currency
 * value.
 *
 */
function number_to_currency(nStr) {
    var num = new NumberFormat();

    num.setInputDecimal('.');
    num.setNumber(nStr);
    num.setPlaces('2', false);
    num.setCurrencyValue('$');
    num.setCurrency(true);
    num.setCurrencyPosition(num.LEFT_OUTSIDE);
    num.setNegativeFormat(num.LEFT_DASH);
    num.setNegativeRed(false);
    num.setSeparators(true, ',', ',');

    return  num.toFormatted();
}
