import { type LocationQueryValue } from 'vue-router'

export function useRouteRedirect(propDefaultRoute: string, routeQuery: LocationQueryValue | LocationQueryValue[]): string {
  if (typeof routeQuery === 'string') {
    return routeQuery || propDefaultRoute
  } else if (Array.isArray(routeQuery) && routeQuery.length > 0) {
    return routeQuery[0] || propDefaultRoute
  }
  return propDefaultRoute
}
