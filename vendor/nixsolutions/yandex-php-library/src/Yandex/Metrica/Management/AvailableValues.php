<?php

namespace Yandex\Metrica\Management;

/**
 * Class AvailableValues
 * @package Yandex\Metrica\Management
 */
class AvailableValues
{
    /**
     * Фильтр по уровню доступа к счетчику.
     * Параметр может содержать несколько значений,
     * разделенных запятой
     */

    // счетчик, принадлежащий пользователю
    const PERMISSION_OWN = "own";

    // гостевой счетчик с уровнем доступа «только просмотр»
    const PERMISSION_VIEW = "view";

    // гостевой счетчик с уровнем доступа «полный доступ»
    const PERMISSION_EDIT = "edit";

    /**
     * Фильтр по типу счетчика
     */

    // счетчик импортирован из РСЯ
    const TYPE_PARTNER = "partner";

    // счетчик создан пользователем в Яндекс.Метрике
    const TYPE_SIMPLE = "simple";

    /**
     * Фильтрация роботов
     */
    // учитывать посещения всех роботов (по умолчанию)
    const FILTER_ROBOTS_0 = 0;

    // фильтровать роботов только по строгим правилам
    const FILTER_ROBOTS_1 = 1;

    // фильтровать роботов по строгим правилам и по поведению
    const FILTER_ROBOTS_2 = 2;

    /**
     * Тип данных, к которым применяется фильтр
     */

    // реферер
    const FILTERS_ATTR_REFERER = "referer";

    // специальный атрибут для фильтра «не учитывать мои посещения»
    const FILTERS_ATTR_UNIQ_ID = "uniq_id";

    // IP-адрес
    const FILTERS_ATTR_CLIENT_IP = "client_ip";

    // заголовок страницы
    const FILTERS_ATTR_TITLE = "title";

    // URL страницы
    const FILTERS_ATTR_URL = "url";

    /**
     * Отношение или действие для фильтра
     */

    // содержит
    const FILTERS_TYPE_EQUAL = "equal";

    // равно
    const FILTERS_TYPE_CONTAIN = "contain";

    // мои посещения, используется только с типом данных attr = uniq_id
    const FILTERS_TYPE_ME = "me";

    // начинается с
    const FILTERS_TYPE_START = "start";

    // в интервале, используется только с типом данных
    // «IP-адрес» (attr = client_ip)
    const FILTERS_TYPE_INTERVAL = "interval";

    // только сайт и зеркала, используется только для
    // типа данных «URL страницы» (attr = url)
    // и типа фильтра «оставить только трафик» (action = include),
    // а также при условии, что для счетчика заданы зеркала
    const FILTERS_TYPE_ONLY_MIRRORS = "only_mirrors";

    /**
     * Тип фильтра
     */

    // оставить только трафик
    const FILTERS_ACTION_INCLUDE = "include";

    // исключить трафик
    const FILTERS_ACTION_EXCLUDE = "exclude";

    /**
     * Статус фильтра
     */

    // фильтр используется
    const FILTERS_STATUS_ACTIVE = "active";

    // фильтр отключен (без удаления)
    const FILTERS_STATUS_DISABLED = "disabled";

    /**
     * Тип операции
     */

    // вырезать определенный параметр из URL
    const OPERATIONS_ACTION_CUT_PARAMETER = "cut_parameter";

    // заменить домен
    const OPERATIONS_ACTION_REPLACE_DOMAIN = "replace_domain";

    // привести к нижнему регистру
    const OPERATIONS_ACTION_TO_LOWER = "to_lower";

    // заменить https:// на http://
    const OPERATIONS_ACTION_MERGE_HTTPS_AND_HTTP = "merge_https_and_http";

    // вырезать якорь из URL
    const OPERATIONS_ACTION_CUT_FRAGMENT = "cut_fragment";

    /**
     * Поле для фильтрации
     */

    // реферер
    const OPERATIONS_ATTR_REFERER = "referer";

    // URL страницы
    const OPERATIONS_ATTR_URL = "url";

    /**
     * Статус операции
     */

    // операция используется
    const OPERATIONS_STATUS_ACTIVE = "active";

    // операция отключена (без удаления)
    const OPERATIONS_STATUS_DISABLED = "disabled";

    /**
     *  Уровень доступа
     */

    // только просмотр
    const GRANTS_PERM_VIEW = "view";

    // полный доступ
    const GRANTS_PERM_EDIT = "edit";

    // публичный доступ к статистике
    const GRANTS_PERM_PUBLIC_STAT = "public_stat";

    /**
     * Запись содержимого страниц
     */

    // загружать с сайта
    const WEBVISOR_ARCH_TYPE_LOAD = "load";

    // из браузера
    const WEBVISOR_ARCH_TYPE_HTML = "html";

    // выключено
    const WEBVISOR_ARCH_TYPE_NONE = "none";

    /**
     * Тип информера
     */

    // расширенный (по умолчанию)
    const INFORMER_TYPE_EXT = "ext";

    // простой
    const INFORMER_TYPE_SIMPLE = "simple";

    /**
     * Размер информера
     */

    // размер 80х15
    const INFORMER_SIZE_1 = 1;

    // размер 80х31
    const INFORMER_SIZE_2 = 2;

    // размер 88х31 (по умолчанию).
    // На вид информера этого типа не влияет значение поля indicator
    const INFORMER_SIZE_3 = 3;

    /**
     * Показатель, который будет отображаться на информере
     */

    // визиты
    const INFORMER_INDICATOR_VISITS = "visits";

    // просмотры (по умолчанию)
    const INFORMER_INDICATOR_PAGEVIEWS = "pageviews";

    // посетители
    const INFORMER_INDICATOR_UNIQUES = "uniques";

    /**
     * Цвет текста на информере
     */

    // черный (по умолчанию)
    const INFORMER_COLOR_TEXT_0 = 0;

    // белый
    const INFORMER_COLOR_TEXT_1 = 1;

    /**
     * Цвет стрелки на информере
     */

    // черный
    const INFORMER_COLOR_ARROW_0 = 0;

    // фиолетовый (по умолчанию)
    const INFORMER_COLOR_ARROW_1 = 1;

    /**
     * Нужно ли удалить зеркала
     */

    // не удалять зеркала (по умолчанию)
    const MIRRORS_REMOVE_0 = 0;

    // игнорировать входящий параметр mirrors (если указан),
    // а также удалить для счетчика ранее заданные зеркала сайта
    const MIRRORS_REMOVE_1 = 1;

    /**
     * Нужно ли удалить цели
     */

    // не удалять цели (по умолчанию)
    const GOALS_REMOVE_0 = 0;

    // игнорировать входящий параметр goals (если указан),
    // а также удалить для счетчика ранее заданные цели
    const GOALS_REMOVE_1 = 1;

    /**
     * Нужно ли удалить фильтры
     */

    // не удалять фильтры (по умолчанию)
    const FILTERS_REMOVE_0 = 0;

    // игнорировать входящий параметр filters (если указан),
    // а также удалить ранее заданные фильтры счетчика
    const FILTERS_REMOVE_1 = 1;

    /**
     * Нужно ли удалить операции
     */

    // не удалять операции (по умолчанию)
    const OPERATIONS_REMOVE_0 = 0;

    // игнорировать входящий параметр operations (если указан),
    // а также удалить ранее заданные операции счетчика
    const OPERATIONS_REMOVE_1 = 1;

    /**
     * Нужно ли удалить настройки доступа
     */

    // не удалять настройки доступа (по умолчанию)
    const GRANTS_REMOVE_0 = 0;

    // игнорировать входящий параметр grants (если указан),
    //а также удалить для счетчика ранее заданные настройки доступа
    const GRANTS_REMOVE_1 = 1;

    /**
     * Тип цели
     */

    // просмотр N страниц
    const GOAL_TYPE_NUMBER = "number";

    // цель типа событие
    const GOAL_TYPE_ACTION = "action";

    // составная цель
    const GOAL_TYPE_STEP = "step";

    // совпадение по URL страницы
    const GOAL_TYPE_URL = "url";

    /**
     * Класс цели
     */

    // обычная цель
    const GOAL_CLASS_0 = 0;

    // цель со сбором подробной статистики
    const GOAL_CLASS_1 = 1;

    // ретаргетинговая цель
    const GOAL_CLASS_2 = 2;

    /**
     * Тип цели для клиентов Яндекс.Маркета
     */

    // «корзина», страница посещения корзины
    const GOAL_FLAG_BASKET = "basket";

    // «заказ», страница подтверждения заказа
    const GOAL_FLAG_ORDER = "order";

    /**
     * Тип условия
     */

    // удовлетворяет регулярному выражению
    const GOAL_CONDITIONS_TYPE_REGEXP = "regexp";

    // содержит
    const GOAL_CONDITIONS_TYPE_CONTAIN = "contain";

    // начинается с
    const GOAL_CONDITIONS_TYPE_START = "start";

    // совпадает
    const GOAL_CONDITIONS_TYPE_EXACT = "exact";

    // специальный тип условия для целей типа action
    const GOAL_CONDITIONS_TYPE_ACTION = "action";
}
