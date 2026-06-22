describe('TC-BF-1R: User mengakses menu keranjang pada landing page', () => {
  it('should access cart page', () => {
    cy.visit('/');
    cy.get('#cartButton').click({force: true});
    cy.screenshot('TC-BF-1R');
  });
});