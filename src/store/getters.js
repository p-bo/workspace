export const getters = {
	// Returns the number of users in a group
	groupUserCount: state => (spaceName, groupName) => {
		const users = state.spaces[spaceName].users
		if (users.length === 0) {
			return 0
		} else {
			// We count all users in the space who have 'groupName' listed in their 'groups' property
			return Object.values(users).filter(user => user.groups.includes(groupName)).length
		}
	},
	// Returns the number of users in a space
	spaceUserCount: state => name => {
		const users = state.spaces[name].users
		if (users.length === 0) {
			return 0
		} else {
			return Object.keys(users).length
		}
	},
	sortedSpaces: state => {
		const sortedSpaces = {}
		Object.keys(state.spaces).sort().forEach((value, index) => {
			sortedSpaces[value] = state.spaces[value]
		})
		return sortedSpaces
	},
}
