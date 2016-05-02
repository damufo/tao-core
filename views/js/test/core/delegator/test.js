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
 * Copyright (c) 2016 (original work) Open Assessment Technologies SA ;
 */
/**
 * @author Jean-Sébastien Conan <jean-sebastien.conan@vesperiagroup.com>
 */
define(['core/delegator'], function(delegator) {
    'use strict';

    QUnit.module('delegator');


    QUnit.test('module', function(assert) {
        QUnit.expect(3);
        
        assert.equal(typeof delegator, 'function', "The delegator module exposes a function");
        assert.equal(typeof delegator(), 'function', 'The delegator helper returns a function');
        assert.notEqual(delegator(), delegator(), 'The delegator helper returns a different function on each call');
    });


    QUnit.test('delegate', function(assert) {
        var delegate;
        var expectedResponse = 'ok';
        var expectedArg1 = 'test1';
        var expectedArg2 = 'test2';
        var api = {
            action: function() {
                assert.ok(true, 'Action called from the api');
                return delegate('action', arguments);
            }
        };
        var adapter = {
            action: function(arg1, arg2) {
                assert.ok(true, 'Action delegated to the adapter');
                assert.equal(arg1, expectedArg1, 'The delegate function forwarded the first argument');
                assert.equal(arg2, expectedArg2, 'The delegate function forwarded the second argument');
                return expectedResponse;
            }
        };

        QUnit.expect(6);
        
        delegate = delegator(api, adapter);
        
        assert.equal(typeof delegate, 'function', 'The delegator helper has created a delegate function');

        assert.equal(api.action(expectedArg1, expectedArg2), expectedResponse, 'The action has returned the expected response');
    });
    

    QUnit.asyncTest('delegate event', function(assert) {
        var delegate;
        var expectedResponse = 'ok';
        var expectedArg1 = 'test1';
        var expectedArg2 = 'test2';
        var api = {
            action: function() {
                assert.ok(true, 'Action called from the api');
                return delegate('action', arguments);
            },

            trigger: function(event, response, arg1, arg2) {
                assert.equal(event, 'action', 'The delegate function has triggered the related event');
                assert.equal(response, expectedResponse, 'The delegate function has forwarded the response');
                assert.equal(arg1, expectedArg1, 'The delegate function has forwarded the first argument');
                assert.equal(arg2, expectedArg2, 'The delegate function has forwarded the second argument');
                QUnit.start();
            }
        };
        var adapter = {
            action: function(arg1, arg2) {
                assert.ok(true, 'Action delegated to the adapter');
                assert.equal(arg1, expectedArg1, 'The delegate function forwarded the first argument');
                assert.equal(arg2, expectedArg2, 'The delegate function forwarded the second argument');
                return expectedResponse;
            }
        };

        QUnit.expect(10);

        delegate = delegator(api, adapter);

        assert.equal(typeof delegate, 'function', 'The delegator helper has created a delegate function');

        assert.equal(api.action(expectedArg1, expectedArg2), expectedResponse, 'The action has returned the expected response');
    });


    QUnit.test('delegate errors', function(assert) {
        var delegate;

        QUnit.expect(4);


        delegate = delegator();
        assert.equal(typeof delegate, 'function', 'The delegator helper has created a delegate function');
        assert.throws(function() {
            delegate('action');
        }, 'An error must be thrown if the delegate function is called with no adapter');

        delegate = delegator({}, {});
        assert.equal(typeof delegate, 'function', 'The delegator helper has created a delegate function');
        assert.throws(function() {
            delegate('action');
        }, 'An error must be thrown if the delegate function is called with an unknown target function');
    });

});
