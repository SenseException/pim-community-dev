Feature: Export locales
  In order to be able to access and modify locales data outside PIM
  As an administrator
  I need to be able to export locales

  @javascript
  Scenario: Successfully export locales
    Given a "footwear" catalog configuration
    And the following job "csv_footwear_locale_export" configuration:
      | filePath | %tmp%/locale_export/locale_export.csv |
    And I am logged in as "Julia"
    And I am on the "csv_footwear_locale_export" export job page
    When I launch the export job
    And I wait for the "csv_footwear_locale_export" job to finish
    Then I should see "Read 210"
    And I should see "Written 210"
    And exported file of "csv_footwear_locale_export" should contain:
    """
    code
    af_ZA
    am_ET
    ar_AE
    ar_BH
    ar_DZ
    ar_EG
    ar_IQ
    ar_JO
    ar_KW
    ar_LB
    ar_LY
    ar_MA
    arn_CL
    ar_OM
    ar_QA
    ar_SA
    ar_SY
    ar_TN
    ar_YE
    as_IN
    az_Cyrl_AZ
    az_Latn_AZ
    ba_RU
    be_BY
    bg_BG
    bn_BD
    bn_IN
    bo_CN
    br_FR
    bs_Cyrl_BA
    bs_Latn_BA
    ca_ES
    co_FR
    cs_CZ
    cy_GB
    da_DK
    de_AT
    de_CH
    de_DE
    de_LI
    de_LU
    dsb_DE
    dv_MV
    el_GR
    en_029
    en_AU
    en_BZ
    en_CA
    en_GB
    en_IE
    en_IN
    en_JM
    en_MY
    en_NZ
    en_PH
    en_SG
    en_TT
    en_US
    en_ZA
    en_ZW
    es_AR
    es_BO
    es_CL
    es_CO
    es_CR
    es_DO
    es_EC
    es_ES
    es_GT
    es_HN
    es_MX
    es_NI
    es_PA
    es_PE
    es_PR
    es_PY
    es_SV
    es_US
    es_UY
    es_VE
    et_EE
    eu_ES
    fa_IR
    fi_FI
    fil_PH
    fo_FO
    fr_BE
    fr_CA
    fr_CH
    fr_FR
    fr_LU
    fr_MC
    fy_NL
    ga_IE
    gd_GB
    gl_ES
    gsw_FR
    gu_IN
    ha_Latn_NG
    he_IL
    hi_IN
    hr_BA
    hr_HR
    hsb_DE
    hu_HU
    hy_AM
    id_ID
    ig_NG
    ii_CN
    is_IS
    it_CH
    it_IT
    iu_Cans_CA
    iu_Latn_CA
    ja_JP
    ka_GE
    kk_KZ
    kl_GL
    km_KH
    kn_IN
    kok_IN
    ko_KR
    ky_KG
    lb_LU
    lo_LA
    lt_LT
    lv_LV
    mi_NZ
    mk_MK
    ml_IN
    mn_MN
    mn_Mong_CN
    moh_CA
    mr_IN
    ms_BN
    ms_MY
    mt_MT
    nb_NO
    ne_NP
    nl_BE
    nl_NL
    nn_NO
    nso_ZA
    oc_FR
    or_IN
    pa_IN
    pl_PL
    prs_AF
    ps_AF
    pt_BR
    pt_PT
    qut_GT
    quz_BO
    quz_EC
    quz_PE
    rm_CH
    ro_RO
    ru_RU
    rw_RW
    sah_RU
    sa_IN
    se_FI
    se_NO
    se_SE
    si_LK
    sk_SK
    sl_SI
    sma_NO
    sma_SE
    smj_NO
    smj_SE
    smn_FI
    sms_FI
    sq_AL
    sr_Cyrl_BA
    sr_Cyrl_CS
    sr_Cyrl_ME
    sr_Cyrl_RS
    sr_Latn_BA
    sr_Latn_CS
    sr_Latn_ME
    sr_Latn_RS
    sv_FI
    sv_SE
    sw_KE
    syr_SY
    ta_IN
    te_IN
    tg_Cyrl_TJ
    th_TH
    tk_TM
    tn_ZA
    tr_TR
    tt_RU
    tzm_Latn_DZ
    ug_CN
    uk_UA
    ur_PK
    uz_Cyrl_UZ
    uz_Latn_UZ
    vi_VN
    wo_SN
    xh_ZA
    yo_NG
    zh_CN
    zh_HK
    zh_MO
    zh_SG
    zh_TW
    zu_ZA
    """
