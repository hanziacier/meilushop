<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// +----------------------------------------------------------------------
// | Ӧ������
// +----------------------------------------------------------------------

return [
    // Ӧ������
    'app_name'               => '',
    // Ӧ�õ�ַ
    'app_rewrite'              => false,
	'app_host'               => '',
    // Ӧ�õ���ģʽ
    'app_debug'              => true,
    // Ӧ��Trace
    'app_trace'              => true,
    // �Ƿ�֧�ֶ�ģ��
    'app_multi_module'       => true,
    // ����Զ���ģ��
    'auto_bind_module'       => false,
    // ע��ĸ������ռ�
    'root_namespace'         => [],
    // Ĭ���������
    'default_return_type'    => 'html',
    // Ĭ��AJAX ���ݷ��ظ�ʽ,��ѡjson xml ...
    'default_ajax_return'    => 'json',
    // Ĭ��JSONP��ʽ���صĴ�����
    'default_jsonp_handler'  => 'jsonpReturn',
    // Ĭ��JSONP������
    'var_jsonp_handler'      => 'callback',
    // Ĭ��ʱ��
    'default_timezone'       => 'Asia/Shanghai',
    // �Ƿ���������
    'lang_switch_on'         => false,
    // Ĭ��ȫ�ֹ��˷��� �ö��ŷָ����
    'default_filter'         => '',
    // Ĭ������
    'default_lang'           => 'zh-cn',
    // Ӧ������׺
    'class_suffix'           => false,
    // ���������׺
    'controller_suffix'      => false,

    // +----------------------------------------------------------------------
    // | ģ������
    // +----------------------------------------------------------------------

    // Ĭ��ģ����
    'default_module'         => 'index',
    // ��ֹ����ģ��
    'deny_module_list'       => ['common'],
    // Ĭ�Ͽ�������
    'default_controller'     => 'Index',
    // Ĭ�ϲ�����
    'default_action'         => 'index',
    // Ĭ����֤��
    'default_validate'       => '',
    // Ĭ�ϵĿ�ģ����
    'empty_module'           => '',
    // Ĭ�ϵĿտ�������
    'empty_controller'       => 'Error',
    // ��������ǰ׺
    'use_action_prefix'      => false,
    // ����������׺
    'action_suffix'          => '',
    // �Զ�����������
    'controller_auto_search' => false,
  // ��ͼ����ַ��������滻
    'view_replace_str'       => [ 
	'__COMMON__'=>INSTALL_PATH.'public/common',
	'__CSS__'=>INSTALL_PATH.'public/admin/css',
	'__JS__'=>INSTALL_PATH.'public/admin/j66s',
	'__IMG__'=>INSTALL_PATH.'public/admin/images',
	],
  
    // +----------------------------------------------------------------------
    // | URL����
    // +----------------------------------------------------------------------

    // PATHINFO������ ���ڼ���ģʽ
    'var_pathinfo'           => 's',
    // ����PATH_INFO��ȡ
    'pathinfo_fetch'         => ['ORIG_PATH_INFO', 'REDIRECT_PATH_INFO', 'REDIRECT_URL'],
    // pathinfo�ָ���
    'pathinfo_depr'          => '/',
    // HTTPS�����ʶ
    'https_agent_name'       => '',
    // IP�����ȡ��ʶ
    'http_agent_ip'          => 'X-REAL-IP',
    // URLα��̬��׺
    'url_html_suffix'        => 'html',
    // URL��ͨ��ʽ���� �����Զ�����
    'url_common_param'       => false,
    // URL������ʽ 0 �����ƳɶԽ��� 1 ��˳�����
    'url_param_type'         => 0,
    // �Ƿ���·���ӳٽ���
    'url_lazy_route'         => false,
    // �Ƿ�ǿ��ʹ��·��
    'url_route_must'         => false,
    // �ϲ�·�ɹ���
    'route_rule_merge'       => false,
    // ·���Ƿ���ȫƥ��
    'route_complete_match'   => false,
    // ʹ��ע��·��
    'route_annotation'       => false,
    // ����������thinkphp.cn
    'url_domain_root'        => '',
    // �Ƿ��Զ�ת��URL�еĿ������Ͳ�����
    'url_convert'            => true,
    // Ĭ�ϵķ��ʿ�������
    'url_controller_layer'   => 'controller',
    // ����������αװ����
    'var_method'             => '_method',
    // ��ajaxαװ����
    'var_ajax'               => '_ajax',
    // ��pjaxαװ����
    'var_pjax'               => '_pjax',
    // �Ƿ������󻺴� true�Զ����� ֧���������󻺴����
    'request_cache'          => false,
    // ���󻺴���Ч��
    'request_cache_expire'   => null,
    // ȫ�����󻺴��ų�����
    'request_cache_except'   => [],
    // �Ƿ���·�ɻ���
    'route_check_cache'      => false,
    // ·�ɻ����Key�Զ������ã��հ�����Ĭ��Ϊ��ǰURL���������͵�md5
    'route_check_cache_key'  => '',
    // ·�ɻ������ͼ�����
    'route_cache_option'     => [],

    // Ĭ����תҳ���Ӧ��ģ���ļ�
    'dispatch_success_tmpl'  => Env::get('think_path') . 'tpl/dispatch_jump.tpl',
    'dispatch_error_tmpl'    => Env::get('think_path') . 'tpl/dispatch_jump.tpl',

    // �쳣ҳ���ģ���ļ�
    'exception_tmpl'         => Env::get('think_path') . 'tpl/think_exception.tpl',

    // ������ʾ��Ϣ,�ǵ���ģʽ��Ч
    'error_message'          => 'ҳ��������Ժ����ԡ�',
    // ��ʾ������Ϣ
    'show_error_msg'         => false,
    // �쳣����handle�� ����ʹ�� \think\exception\Handle
    'exception_handle'       => '',

];
