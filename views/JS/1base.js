function isJson(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return true;
    }
    return false;
}
