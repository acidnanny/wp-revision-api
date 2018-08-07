<?php

namespace DPress\Revisions;

class RevisionsAPI {

	/**
	 * @var \DPress\Revisions\RevisionHandler[]
	 */
	protected $handlers = array();

	/**
	 * RevisionAPI constructor.
	 */
	public function __construct() {
		$api = $this;

		// allow triggering revision saving on non core fields
		add_filter('wp_save_post_revision_post_has_changed', function($has_changed, $previous_revision, $post) use($api) {
			if ($has_changed)
				return $has_changed;

			return $api->hasChanged($previous_revision, $post);
		}, 10, 3);

		// save revisions
		add_action('save_post', function($post_id) use($api) {
			$post = get_post($post_id);
			if ($post->post_type != 'revision') {
				return;
			}

			$original = get_post($post->post_parent);
			$api->saveRevision($original, $post);
		});

		// handle restoring revision
		add_action('wp_restore_post_revision', function($post_id, $revision_id) use($api) {
			$api->restoreRevision(get_post($post_id), get_post($revision_id));
		}, 10, 2);

		add_filter('wp_get_revision_ui_diff', function($diff_array, $compare_from, $compare_to) use($api) {
			/**
			 * @var \WP_Post $compare_from
			 * @var \WP_Post $compare_to
			 */
			$post_type = $compare_to->post_type;
			if ($compare_to->post_parent > 0)
				$post_type = get_post($compare_to->post_parent)->post_type;

			return array_merge($diff_array, $api->getDiff($post_type, $compare_from, $compare_to));
		}, 10, 3);
	}

	public function addHandler(RevisionHandler $handler) {
		$this->handlers[] = $handler;
	}

	/**
	 * @param \WP_Post $from_post
	 * @param \WP_Post $to_post
	 *
	 * @return bool
	 */
	protected function hasChanged($from_post, $to_post) {
		foreach($this->handlers as $handler) {
			if ($handler->isDifferent($from_post, $to_post))
				return true;
		}

		return false;
	}

	protected function saveRevision(\WP_Post $post, \WP_Post $revision) {
		foreach($this->handlers as $handler) {
			$handler->saveRevision($post, $revision);
		}
	}

	protected function restoreRevision(\WP_Post $post, \WP_Post $revision) {
		foreach($this->handlers as $handler) {
			$handler->restoreRevision($revision, $post);
		}
	}

	protected function getDiff($post_type, $from_post, $to_post) {
		$ret = [];
		foreach($this->handlers as $handler) {
			foreach($handler->diffRevision($post_type, $from_post, $to_post) as $diff) {
				$ret[] = array(
					'id' => $diff->getFieldName(),
					'name' => $diff->getFieldCaption(),
					'diff' => $diff->getFieldDiffMarkup()
				);
			}
		}

		return $ret;
	}
}