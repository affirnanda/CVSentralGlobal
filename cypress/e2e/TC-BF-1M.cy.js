describe('TC-BF-1M: User mengakses menu dashboard pada landing page', () => {
  it('should access landing page', () => {
    cy.visit('/');
    cy.screenshot('TC-BF-1M');
  });
});