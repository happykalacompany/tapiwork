/**
 * 定义不同环境下使用的api调用请求头
 */
var api_url = '';
var gaode_map_js_api_key = 'fb7a78fdcc78bd6b20f9feb18b0bf7fa';
var app_url = '';
switch(process.env.NODE_ENV){
    case'development':
        api_url = 'http://tapiwork.test/api/v1';
        app_url = 'http://tapiwork.test';
        break;
    case'production':
        api_url = 'http://tapiwork.test/api/v1';
        app_url = 'http://tapiwork.test';
        break;
}

export const TAPIWORK_CONFIG = {
    API_URL:api_url,
    GAODE_MAP_JS_API_KEY:gaode_map_js_api_key,
    APP_URL:app_url
}
