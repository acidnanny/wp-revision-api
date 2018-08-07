<?php

namespace DPress\Revisions;

interface RevisionHandler {
	/**
	 * Should be the same as your post save handler
	 * @param \WP_Post $post
	 * @param \WP_Post $revision
	 */
	public function saveRevision($post, $revision);

	/**
	 * @param string $post_type
	 * @param \WP_Post $from_post
	 * @param \WP_Post $to_post
	 *
	 * @return \DPress\Revisions\RevisionFieldDiff[]
	 */
	public function diffRevision($post_type, $from_post, $to_post);

	/**
	 * Return true if there is a difference between posts
	 * @param \WP_Post $from_post
	 * @param \WP_Post $to_post
	 *
	 * @return boolean
	 */
	public function isDifferent($from_post, $to_post);

	/**
	 * Should update $post to match $revision
	 * @param \WP_Post $revision
	 * @param \WP_Post $post
	 *
	 * @return void
	 */
	public function restoreRevision($revision, $post);
}