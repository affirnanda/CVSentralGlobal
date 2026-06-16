describe('TC-BF-1N: User mengakses menu profile pada landing page', () => {
  it('should see Profile menu', () => {
    cy.visit('/');
    cy.contains(/Profile/i).should('exist');
    cy.screenshot('TC-BF-1N');
  });
});