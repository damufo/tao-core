<?php
/**
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; under version 2
 * of the License (non-upgradable).
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 *
 * Copyright (c) 2018 (original work) Open Assessment Technologies SA (under the project TAO-PRODUCT);
 */

namespace oat\tao\model\user\import;

interface UserMapper
{
    const OPTION_SCHEMA = 'schema';
    const OPTION_SCHEMA_MANDATORY = 'mandatory';
    const OPTION_SCHEMA_OPTIONAL = 'optional';

    /**
     * Map CSV column to user properties
     *
     * @param array $data
     * @throws \Exception
     * @return UserMapper
     */
    public function map(array $data = []);

    /**
     * Merge some $extraProperties to already mapped properties
     *
     * @param array $extraProperties
     * @return UserMapper
     */
    public function combine(array $extraProperties);

    /**
     * Check is current mapper achieve to extract data
     *
     * @return bool
     */
    public function isEmpty();

    /**
     * Get the plain password
     *
     * @return string|null
     */
    public function getPlainPassword();

    /**
     * Get user mapped properties
     *
     * @return array
     */
    public function getProperties();
}