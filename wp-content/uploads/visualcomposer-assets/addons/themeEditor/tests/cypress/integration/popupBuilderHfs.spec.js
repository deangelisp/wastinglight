/* global describe, it, cy */

describe('Test Popup Builder with HFS', function () {
  it('Uses php-e2e-actions to load page with hfs and popup inside', function () {

    // http://127.0.0.1:8000/wp-content/plugins/visualcomposer/tests/php-e2e-actions/init.php/?php-e2e=1&php-e2e-action=test-asset-enqueue
    cy.visit('/wp-content/plugins/' + Cypress.env('dataPlugin').replace('/plugin-wordpress.php', '') + '/tests/php-e2e-actions/init.php/?php-e2e=1&php-e2e-action=test-themeEditor-popupBuilder')

    cy.get('#php-e2e-popup-id')
      .then((element) => {
        cy.window().then((window) => {
          const popupId = element.text()
          // Test:
          // Check is there vcv-popup-${popupId} exists
          // Check is it visible (it must as onPageLoad should happen)
          // Check source-css of popup is it loaded correctly
          cy.wait(1000) // 1s wait till document.ready will be 100% called
          cy.get('#vcv-popup-' + popupId)
            .contains('This is test popup')

          cy.get('#vcv-popup-' + popupId + ' #popup-button-yellow').should('have.css', 'color', 'rgb(255, 255, 255)')
          cy.get('#vcv-popup-' + popupId + ' #popup-button-yellow').should('have.css', 'background-color', 'rgb(255, 222, 0)')
          cy.get('#vcv-popup-' + popupId + ' .vce-popup-root-container').should('have.css', 'align-items', 'flex-end')
          cy.get('#vcv-popup-' + popupId + ' .vce-popup-root-container').should('have.class', 'vcv-popup-container--visible')
          cy.get('#vcv-popup-' + popupId + ' .vce-popup-root-container').should('be.visible')
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
