/* global describe, it, cy */

describe('globalElementCssInContentSequence', function () {
  it('Uses php-e2e-actions to load page with custom globalTemplate CSS', function () {
    const actionsPages = [
      {
        action: 'test-themeEditor-in-header-source-css-location',
        header: true,
        content: false,
        footer: false
      },
      {
        action: 'test-themeEditor-globalTemplate-in-content-source-css-location',
        header: false,
        content: true,
        footer: false
      },
      {
        action: 'test-themeEditor-globalTemplate-in-footer-source-css-location',
        header: false,
        content: false,
        footer: true,
      },
      {
        action: 'test-themeEditor-in-everywhere-source-css-location',
        header: true,
        content: true,
        footer: true
      },
    ]
    const layouts = ['header-footer-layout', 'header-footer-sidebar-layout', 'header-footer-sidebar-left-layout']
    const prefixes = [
      {
        type: 'header',
        selector: '.vcv-header'
      }, {
        type: 'content',
        selector: '.entry-content'
      }, {
        type: 'footer',
        selector: '.vcv-footer'
      },
    ]
    actionsPages.forEach((action) => {
      layouts.forEach((layout) => {
        // http://127.0.0.1:8000/wp-content/plugins/visualcomposer/tests/php-e2e-actions/init.php/?php-e2e=1&php-e2e-action=test-asset-enqueue
        cy.visit('/wp-content/plugins/' + Cypress.env('dataPlugin').replace('/plugin-wordpress.php', '') + '/tests/php-e2e-actions/init.php/?php-e2e=1&php-e2e-action=' + action.action + '&php-e2e-layout=' + layout)

        prefixes.forEach((prefix) => {
          if (!action[prefix.type]) {
            return;
          }
          // Test:
          // Check is template rendered, sourceCss is loaded in HEAD and it values is correct
          cy.get('#e2e-unique-' + prefix.type + '-id')
            .then((element) => {
              cy.window().then((window) => {
                const uniqueId = element.text()

                cy.get(prefix.selector + ' #vcv-global-template-' + uniqueId)
                  .contains('Angie McQueen')

                cy.get(prefix.selector + ' #vcv-global-template-' + uniqueId + ' .vce-button--style-3d-inner').should('have.css', 'color', 'rgb(255, 255, 255)')
                cy.get(prefix.selector + ' #vcv-global-template-' + uniqueId + ' .vce-button--style-animated-three-color-inner').should('have.css', 'color', 'rgb(255, 255, 255)')
                cy.get(prefix.selector + ' #vcv-global-template-' + uniqueId + ' .may6-global-css-' + prefix.type + '').then((templateElement) => {
                  const before = window.getComputedStyle(templateElement[0], 'before')
                  const beforeColor = before.getPropertyValue('color')
                  const content = before.getPropertyValue('content')

                  expect(beforeColor).to.eq('rgb(0, 128, 0)')
                  expect(content).to.have.string(uniqueId)
                })

                // Check is template source-css is loaded in <HEAD> tag
                cy.get('#e2e-' + prefix.type + '-globalTemplate-sourceCss-url')
                  .then((cssLinkDomElement) => {
                    const globalTemplateSourceCssUrl = cssLinkDomElement.text()

                    expect(window.document.querySelector('link[href*="' + globalTemplateSourceCssUrl + '"]').parentNode.tagName).to.equal(prefix.type === 'header' ? 'HEAD' : 'DIV')
                    if (prefix.type !== 'header') {
                      expect(window.document.querySelector('link[href*="' + globalTemplateSourceCssUrl + '"]').parentNode.id).to.equal('vcv-global-template-' + uniqueId)
                      // Check is the <link> position is before template HTML: with nextElementSibling
                      expect(window.document.querySelector('link[href*="' + globalTemplateSourceCssUrl + '"]').nextElementSibling.querySelector('.vce-button--style-3d-inner').textContent).to.equal('Apply Now')
                    }
                  })
              })
            })
        })
      })
    })

    // Clean the DB:
    cy.visit('/wp-content/plugins/' + Cypress.env('dataPlugin').replace('/plugin-wordpress.php', '') + '/tests/php-e2e-actions/init.php/?php-e2e=1&php-e2e-action=clean-e2e-posts-db')
    // Make sure DB clean was success
    cy.window().then((window) => {
      expect('Done').to.equal(window.document.body.textContent)
    })
  })
})
