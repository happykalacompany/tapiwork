/**
 * 定义不同环境下使用的api调用请求头
 */
var api_url = '';

switch(process.env.NODE_ENV){
    case'development':
        api_url = 'http://tapiwork.test/api/v1';
        break;
    case'production':
        api_url = 'http://tapiwork.test/api/v1';
        break;
}

export const TAPIWORK_CONFIG = {
    API_URL:api_url
}
