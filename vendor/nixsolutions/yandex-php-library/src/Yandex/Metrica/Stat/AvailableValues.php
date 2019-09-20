<?php

namespace Yandex\Metrica\Stat;

class AvailableValues
{
    /**
     * Точность вычисления результата.
     * Позволяет управлять семплированием (количеством визитов,
     * использованных при расчете итогового значения).
     *
     * Значение по умолчанию: medium
     */

    // возвращает наиболее точное значение,
    // используя наибольшую выборку данных.
    // Этот режим может потребовать дополнительное время
    // и замедлить обработку запроса (размер выборки — 10 000 000)
    const ACCURACY_HIGH = "high";

    // возвращает быстрый результат на основе сокращенной
    // выборки данных (размер выборки — 100 000)
    const ACCURACY_LOW = "low";

    // возвращает результат на основе выборки, сочетающей
    // скорость и точность данных (размер выборки — 1000 000)
    const ACCURACY_MEDIUM = "medium";

    /**
     * Данные шаблоны позволяют сформировать отчеты об
     * источниках посещаемости сайта
     */

    // Поисковые системы
    const PRESET_SEARCH_ENGINES = "search_engines";

    // Поисковые фразы
    const PRESET_SOURCES_SEARCH_PHRASES = "sources_search_phrases";

    // Сайты
    const PRESET_SOURCES_SITES = "sources_sites";

    // Социальные сети
    const PRESET_SOURCES_SOCIAL = "sources_social";

    // Сводка
    const PRESET_SOURCES_SUMMARY = "sources_summary";

    // Метка from
    const PRESET_TAGS_FROM = "tags_from";

    // Метка gcl
    const PRESET_TAGS_GCLID = "tags_gclid";

    // Метка openstat
    const PRESET_TAGS_OPENSTAT = "tags_openstat";

    // Метка utm
    const PRESET_TAGS_U_T_M = "tags_u_t_m";

    // Рекламные системы
    const PRESET_ADV_ENGINE = "adv_engine";

    /**
     * Данные шаблоны позволяют сформировать отчеты о
     * посещаемости сайта с распределением по странам
     */

    // География
    const PRESET_GEO_COUNTRY = "geo_country";

    /**
     * Данные шаблоны позволяют сформировать отчеты о страницах,
     * которые посетил пользователь
     */

    // Страница входа
    const PRESET_CONTENT_ENTRANCE = "content_entrance";

    // Страница выхода
    const PRESET_CONTENT_EXIT = "content_exit";

    // Параметры визитов
    const PRESET_CONTENT_VISIT_PARAMS = "content_visit_params";

    // Популярное
    const PRESET_POPULAR = "popular";

    // Заголовки страниц
    const PRESET_TITLES = "titles";

    // Параметры URL
    const PRESET_URL_PARAMS = "url_params";

    /**
     * Данные шаблоны позволяют сформировать отчеты
     * об устройствах и программном обеспечении,
     * которые используют посетители сайта
     */

    // Размер окна браузера
    const PRESET_RESOLUTION_MAP = "resolution_map";

    // Браузеры
    const PRESET_TECH_BROWSERS = "tech_browsers";

    // Наличие Cookies
    const PRESET_TECH_COOKIES = "tech_cookies";

    // Разрешения дисплеев
    const PRESET_TECH_DISPLAY = "tech_display";

    // Группы дисплеев
    const PRESET_TECH_DISPLAY_GROUPS = "tech_display_groups";

    // Версии Flash
    const PRESET_TECH_FLASH = "tech_flash";

    // Наличие Java
    const PRESET_TECH_JAVA = "tech_java";

    // Наличие Javascript
    const PRESET_TECH_JAVA_SCRIPT = "tech_java_script";

    // Мобильность
    const PRESET_TECH_MOBILE = "tech_mobile";

    // Операционные системы
    const PRESET_TECH_PLATFORMS = "tech_platforms";

    // Версии Silverlight
    const PRESET_TECH_SILVERLIGHT = "tech_silverlight";

    // Мобильные устройства
    const PRESET_MOBILE_PHONES = "mobile_phones";

    /**
     * Данные шаблоны позволяют сформировать отчеты
     * о посещаемости сайта с течением времени
     */

    // Трафик
    const PRESET_TRAFFIC = "traffic";

    // Визиты
    const PRESET_HOURLY = "hourly";
}
