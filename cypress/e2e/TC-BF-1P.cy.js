describe('TC-BF-1P: User mengakses menu testimoni pada landing page', () => {
  it('should see Testimonial menu', () => {
    cy.visit('/');
    cy.contains(/Testimonial/i).should('exist');
    cy.screenshot('TC-BF-1P');
  });
});