describe('TC-BF-1Q: User mengakses menu FAQ pada landing page', () => {
  it('should see FAQ menu', () => {
    cy.visit('/');
    cy.contains(/FAQ/i).should('exist');
    cy.screenshot('TC-BF-1Q');
  });
});