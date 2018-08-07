<?php

namespace DPress\Revisions;

class RevisionFieldDiff {
	protected $fieldName = '';
	protected $fieldCaption = '';
	protected $fieldDiffMarkup = '';

	/**
	 * RevisionFieldDiff constructor.
	 *
	 * @param string $fieldName
	 * @param string $fieldCaption
	 * @param string $fieldDiffMarkup
	 */
	public function __construct( $fieldName = '', $fieldCaption = '', $fieldDiffMarkup = '') {
		$this->fieldName       = $fieldName;
		$this->fieldCaption    = $fieldCaption;
		$this->fieldDiffMarkup = $fieldDiffMarkup;
	}

	/**
	 * @return string
	 */
	public function getFieldName() {
		return $this->fieldName;
	}

	/**
	 * @param string $fieldName
	 */
	public function setFieldName( $fieldName ) {
		$this->fieldName = $fieldName;
	}

	/**
	 * @return string
	 */
	public function getFieldCaption() {
		return $this->fieldCaption;
	}

	/**
	 * @param string $fieldCaption
	 */
	public function setFieldCaption( $fieldCaption ) {
		$this->fieldCaption = $fieldCaption;
	}

	/**
	 * @return string
	 */
	public function getFieldDiffMarkup() {
		return $this->fieldDiffMarkup;
	}

	/**
	 * @param string $fieldDiffMarkup
	 */
	public function setFieldDiffMarkup( $fieldDiffMarkup ) {
		$this->fieldDiffMarkup = $fieldDiffMarkup;
	}
}