
/**
 * @class
 */
var CacheLocal = function () {

    /**
     * @type {CacheLocal}
     */
    var localCache = this;

    /**
     * @function for storing local data
     * @param {string|int} index
     * @param {string|int} value
     */
    localCache.store = function (index, value) {
        localCache[index] = value;
    };

    /**
     * @function for checking for already existing content
     * @param {string|int} index
     * @returns {boolean}
     */
    localCache.hasCache = function (index) {
        return (index in localCache);
    };

    /**
     * @function for retrieving local data
     * @param {string|int} index
     * @returns {string|int} empty string on missing index
     */
    localCache.retrieve = function (index) {
        return (localCache.hasCache(index)) ? localCache[index] : "";
    };

    /**
     * @function for removing specific cache key
     * @param {string|int} index
     */
    localCache.remove = function (index) {
        delete localCache[index];
    };

    /**
     * @function for resetting cache
     */
    localCache.clear = function () {
        localCache = new CacheLocal();
    };

    return localCache;
};