<?php
/*
 * ==========================================================================
 *
 * [DBテーブル設定]
 *
 * ==========================================================================
 */
namespace azlink\workspace\config;
/**
 * テーブル名の設定
 * 基本的にはTABLE_PREFの設定のみでOK
 */
const TABLE_PREFIX      = 'mr_'; 									// prefix
const TABLE_CATS        = TABLE_PREFIX . 'categories'; 				// カテゴリ
const TABLE_CAT_REL     = TABLE_PREFIX . 'category_relationships'; 	// カテゴリ+投稿関連付け
const TABLE_USERS       = TABLE_PREFIX . 'users'; 					// ユーザ
const TABLE_ROLES       = TABLE_PREFIX . 'roles'; 					// 権限
const TABLE_POSTS       = TABLE_PREFIX . 'posts'; 					// 投稿情報
const TABLE_TAGS        = TABLE_PREFIX . 'tags'; 					// 付加タグ
const TABLE_TAG_REL     = TABLE_PREFIX . 'tag_relationships'; 		// タグ+投稿関連付け
